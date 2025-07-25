<?php
ob_start();
error_reporting(0);
ini_set('display_errors', 0);

require('fpdf.php');

/* ───────  FUNCIÓN: número a letras  ───────
   Requiere la extensión intl de PHP      */
function numero_a_letras($numero)
{
    if (class_exists('NumberFormatter')) {
        $fmt = new NumberFormatter('es', NumberFormatter::SPELLOUT);
        return $fmt->format($numero);
    }
    // Fallback muy básico (solo miles) si intl no está disponible
    return $numero;
}

/* ───────  ENTRADAS  ─────── */
$cedula = $_POST['id'] ?? '';
$destinatario = $_POST['destinatario'] ?? '';
$salario_sn = $_POST['salario_sn'] ?? 'NO';
$titulo = $_POST['titulo'] ?? '';

include("../php/conexion.php");
$consulta_info = $conexion->query("
    SELECT * FROM integrantes a
    JOIN info_integrantes b ON a.cedula = b.cedula
    WHERE a.cedula = '$cedula'
");

/* Meses en español */
$meses = [
    '01' => 'enero',
    '02' => 'febrero',
    '03' => 'marzo',
    '04' => 'abril',
    '05' => 'mayo',
    '06' => 'junio',
    '07' => 'julio',
    '08' => 'agosto',
    '09' => 'septiembre',
    '10' => 'octubre',
    '11' => 'noviembre',
    '12' => 'diciembre'
];

if ($consulta_info->num_rows > 0) {
    $d = $consulta_info->fetch_object();
    $nombre_completo = mb_strtoupper($d->nombres . ' ' . $d->apellidos, 'UTF-8');
    $cargo = mb_strtoupper($d->cargo, 'UTF-8');
    $fecha_ingreso = $d->fecha_ingreso;
    $tipo_contrato = mb_strtoupper($d->tipo_contrato, 'UTF-8');
    $salario = isset($d->salario) ? floatval(str_replace('.', '', $d->salario)) : 0;
    $salario_letras = mb_strtoupper(numero_a_letras($salario), 'UTF-8');
    $auxilio = isset($d->auxilio) ? floatval(str_replace('.', '', $d->auxilio)) : 0;
    $auxilio_letras = mb_strtoupper(numero_a_letras($auxilio), 'UTF-8');
    $neto_pagar = isset($d->total) ? floatval(str_replace('.', '', $d->total)) : 0;
    $neto_letras = mb_strtoupper(numero_a_letras($neto_pagar), 'UTF-8');
    $integral = $d->integral;

    $fecha_actual = date('d') . ' de ' . $meses[date('m')] . ' del ' . date('Y');

    session_start();
    date_default_timezone_set('America/Bogota');

    $fecha_generacion = date('Y-m-d H:i:s');
    $tipo = 'Certificado Laboral';
    $observaciones = 'Dirigido a: ' . $titulo . ' ' . $destinatario;

    $sql_bitacora = "INSERT INTO bitacora (cedula_empleado, fecha_generacion, tipo, observaciones)
                         VALUES (?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql_bitacora);
    $stmt->bind_param("ssss", $cedula, $fecha_generacion, $tipo, $observaciones);
    $stmt->execute();
    $stmt->close();

}

/* ───────  CLASE PDF  ─────── */
class PDF extends FPDF
{
    function __construct($header_img, $footer_img)
    {
        parent::__construct();
        $this->header_img = $header_img;
        $this->footer_img = $footer_img;
        $this->AddFont('montserrat', '', 'Montserrat-Regular.php');
        $this->AddFont('montserrat', 'B', 'Montserrat-Bold.php');
    }
    function Header()
    {
        $this->Image($this->header_img, 0, 0, 210);
        $this->SetY(45);
    }
    function Footer()
    {
        $this->Image($this->footer_img, 0, $this->GetPageHeight() - 19, 210);
        $this->SetY(-15);
        $this->SetFont('montserrat', '', 8);
    }
}

$pdf = new PDF('membrete.png', 'membrete_2.png');
$pdf->AddPage('P', 'A4');



if ($titulo != 'En blanco') {
    $pdf->SetFont('montserrat', 'B', 10);
    $pdf->MultiCell(0, 10, utf8_decode($titulo . ' ' . $destinatario), 0, 'L');
    $pdf->Ln(4);
}

/* Encabezado empresa */
$pdf->SetFont('montserrat', 'B', 11);
$pdf->Cell(0, 10, 'DATABIZ S.A.S', 0, 1, 'C');
$pdf->SetFont('montserrat', '', 10);
$pdf->Cell(0, 10, 'NIT 900641482-1', 0, 1, 'C');
$pdf->Ln(6);

/* Subtítulo */
$pdf->SetFont('montserrat', 'B', 10);
$pdf->Cell(0, 10, 'HACE CONSTAR', 0, 1, 'C');
$pdf->Ln(4);

/* Cuerpo */
$pdf->SetFont('montserrat', '', 10);
$pdf->Write(10, utf8_decode('Que '));

$pdf->SetFont('montserrat', 'B', 10);
$pdf->Write(10, utf8_decode($nombre_completo));

$pdf->SetFont('montserrat', '', 10);
$pdf->Write(10, utf8_decode(' identificado(a) con cédula de ciudadanía N° '));

$pdf->SetFont('montserrat', 'B', 10);
$pdf->Write(10, utf8_decode($cedula));

$pdf->SetFont('montserrat', '', 10);
$pdf->Write(10, utf8_decode(' labora en nuestra compañía desde el '));

$pdf->SetFont('montserrat', 'B', 10);
$pdf->Write(10, utf8_decode($fecha_ingreso));

$pdf->SetFont('montserrat', '', 10);
$pdf->Write(10, utf8_decode(' desempeñando el cargo de '));

$pdf->SetFont('montserrat', 'B', 10);
$pdf->Write(10, utf8_decode($cargo));

$pdf->SetFont('montserrat', '', 10);
$pdf->Write(10, utf8_decode(', con un contrato a término '));

$pdf->SetFont('montserrat', 'B', 10);
$pdf->Write(10, utf8_decode($tipo_contrato) . '.');

if ($salario_sn === 'SI') {
    if (trim(strtoupper($integral)) == 'NO') {
        $pdf->SetFont('montserrat', '', 10);
        $pdf->Write(10, utf8_decode(', devengando un salario mensual de '));
        $pdf->SetFont('montserrat', 'B', 10);
        $pdf->Write(10, utf8_decode($salario_letras . ' PESOS M/CTE. '));
        $pdf->Write(10, utf8_decode('($' . number_format($salario, 0, ',', '.') . ') '));
        $pdf->SetFont('montserrat', '', 10);
        $pdf->Write(10, utf8_decode(', más todas las prestaciones de ley.'));
        $pdf->Ln(15);
        $pdf->SetFont('montserrat', '', 10);
        $pdf->Write(10, utf8_decode('Un auxilio mensual no salarial de '));
        $pdf->SetFont('montserrat', 'B', 10);
        $pdf->Write(10, utf8_decode($auxilio_letras . ' PESOS M/CTE. '));
        $pdf->Write(10, utf8_decode('($' . number_format($auxilio, 0, ',', '.') . ')'));
        $pdf->Ln(15);
        $pdf->SetFont('montserrat', '', 10);
        $pdf->Write(10, utf8_decode('Para un total de '));
        $pdf->SetFont('montserrat', 'B', 10);
        $pdf->Write(10, utf8_decode($neto_letras . ' PESOS M/CTE. '));
        $pdf->Write(10, utf8_decode('($' . number_format($neto_pagar, 0, ',', '.') . ')'));
    } else {
        $pdf->SetFont('montserrat', '', 10);
        $pdf->Write(10, utf8_decode(', devengando un salario mensual de '));
        $pdf->SetFont('montserrat', 'B', 10);
        $pdf->Write(10, utf8_decode($neto_letras . ' PESOS M/CTE. '));
        $pdf->Write(10, utf8_decode('($' . number_format($neto_pagar, 0, ',', '.') . ') '));
        $pdf->SetFont('montserrat', '', 10);
        $pdf->Write(10, utf8_decode(', más todas las prestaciones de ley.'));
    }
}
$pdf->Ln(15);
$pdf->SetFont('montserrat', '', 10);
$pdf->MultiCell(0, 10, utf8_decode('Esta certificación se expide el día ' . $fecha_actual . '.'), 0, 'L');
$pdf->Ln(5);
$pdf->MultiCell(0, 10, 'Sin otro particular,', 0, 'L');
$pdf->Image('firma_lorena.jpg', $pdf->GetX(), $pdf->GetY(), 40); 
$pdf->Ln(30); 
$pdf->SetFont('montserrat', 'B', 10);
$pdf->Cell(0, 10, 'Lorena Acosta', 0, 'L');
$pdf->Ln(-4);
$pdf->MultiCell(0, 10, utf8_decode('Líder de Talento Humano'), 0, 'L');
$pdf->Ln(-4);
$pdf->MultiCell(0, 10, 'DATABIZ S.A.S', 0, 'L');

/* Salida */
ob_end_flush();
$pdf->Output($nombre_completo . ' ' . $cedula . '.pdf', 'I');
?>