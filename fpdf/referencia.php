<?php
require('fpdf.php');
error_reporting(0);
ini_set('display_errors', 0);

/* ───── FUNCIÓN: número a letras ───── */
function numero_a_letras($numero) {
    if (class_exists('NumberFormatter')) {
        $fmt = new NumberFormatter('es', NumberFormatter::SPELLOUT);
        return $fmt->format($numero);
    }
    return $numero;
}

$cedula = $_GET['cedula'] ?? ''; // Usa 'cedula' (no 'id')
if (empty($cedula)) {
    die('Cédula no proporcionada.');
}

include("../php/conexion.php");

$consulta_info = $conexion->query("
    SELECT * FROM integrantes a
    JOIN info_integrantes b ON a.cedula = b.cedula
    WHERE a.cedula = '$cedula'
");

if ($consulta_info->num_rows === 0) {
    die('No se encontró información del integrante.');
}

$d = $consulta_info->fetch_object();
$nombre_completo = mb_strtoupper($d->nombres . ' ' . $d->apellidos, 'UTF-8');
$cargo = mb_strtoupper($d->cargo, 'UTF-8');
$fecha_ingreso = $d->fecha_ingreso ?? '---';
$fecha_retiro = $d->fecha_retiro ?? 'A la fecha';
$integral = $d->integral ?? '';

$meses = [
    '01' => 'enero', '02' => 'febrero', '03' => 'marzo', '04' => 'abril',
    '05' => 'mayo', '06' => 'junio', '07' => 'julio', '08' => 'agosto',
    '09' => 'septiembre', '10' => 'octubre', '11' => 'noviembre', '12' => 'diciembre'
];

$fecha_actual = date('d') . ' de ' . $meses[date('m')] . ' del ' . date('Y');

/* Registrar bitácora */
session_start();
date_default_timezone_set('America/Bogota');
$fecha_generacion = date("Y-m-d H:i:s");
$tipo = "Referencia Laboral";
$observaciones = "Generada desde el sistema";

$sql_bitacora = "INSERT INTO bitacora (cedula_integrante, fecha_generacion, tipo, observaciones)
                 VALUES (?, ?, ?, ?)";
$stmt = $conexion->prepare($sql_bitacora);
$stmt->bind_param("ssss", $cedula, $fecha_generacion, $tipo, $observaciones);
$stmt->execute();
$stmt->close();

/* CLASE PDF */
class PDF extends FPDF {
    function __construct($header_img, $footer_img) {
        parent::__construct();
        $this->header_img = $header_img;
        $this->footer_img = $footer_img;
        $this->AddFont('montserrat', '', 'Montserrat-Regular.php');
        $this->AddFont('montserrat', 'B', 'Montserrat-Bold.php');
    }
    function Header() {
        $this->Image($this->header_img, 0, 0, 210);
        $this->SetY(45);
    }
    function Footer() {
        $this->Image($this->footer_img, 0, $this->GetPageHeight() - 19, 210);
        $this->SetY(-15);
        $this->SetFont('montserrat', '', 8);
    }
}

$pdf = new PDF('membrete.png', 'membrete_2.png');
$pdf->AddPage('P', 'A4');

$pdf->SetFont('montserrat', 'B', 11);
$pdf->Cell(0, 10, 'DATABIZ S.A.S', 0, 1, 'C');
$pdf->SetFont('montserrat', '', 10);
$pdf->Cell(0, 10, 'NIT 900641482', 0, 1, 'C');
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
$pdf->Write(10, utf8_decode(' hasta el día '));
$pdf->SetFont('montserrat', 'B', 10);
$pdf->Write(10, utf8_decode($fecha_retiro));
$pdf->SetFont('montserrat', '', 10);
$pdf->Write(10, utf8_decode(' desempeñando el cargo de '));
$pdf->SetFont('montserrat', 'B', 10);
$pdf->Write(10, utf8_decode($cargo));

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
$pdf->Output($nombre_completo . ' ' . $cedula . '.pdf', 'I');
?>
