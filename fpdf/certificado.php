<?php
require('fpdf.php');

$cedula = $_POST['id'] ?? '';
$destinatario = $_POST['destinatario'] ?? '';

include("../php/conexion.php");
$consulta_info = $conexion->query("select * from empleados a, info_empleados b where a.cedula = b.cedula and a.cedula = '$cedula'");

if ($consulta_info->num_rows > 0) {
   $dato_info = $consulta_info->fetch_object();
   $nombre_completo = $dato_info->nombres . ' ' . $dato_info->apellidos;
   $cargo = $dato_info->cargo;
   $neto_pagar = $dato_info->total;
   $fecha_ingreso = $dato_info->fecha_ingreso;
   $tipo_contrato = $dato_info->tipo_contrato;
   $salario = $dato_info->salario;
   $auxilio = $dato_info->auxilio;
} else {
   $nombre_completo = "No disponible";
   $cargo = "No disponible";
   $neto_pagar = "No disponible";
   $fecha_ingreso = "No disponible";
}

// Clase personalizada
class PDF extends FPDF
{
    function __construct($header_img, $footer_img) {
        parent::__construct();
        $this->header_img = $header_img;
        $this->footer_img = $footer_img;
        $this->AddFont('montserrat', '', 'Montserrat-Regular.php');
        $this->AddFont('montserrat', 'B', 'Montserrat-Bold.php');
    }

    function Header()
    {
        $this->Image($this->header_img, 0, 0, 210); // Ajusta el ancho si es necesario
        $this->SetY(45); // Baja el cursor para no sobreponer
    }

    function Footer()
    {
        $this->Image($this->footer_img, 0, $this->GetPageHeight() - 23, 210); // Imagen al pie, ajustar si es necesario
        $this->SetY(-15);
        $this->SetFont('montserrat', '', 8);
    }
}

// Crear PDF
$pdf = new PDF('membrete.png', 'membrete_2.png');
$pdf->AddPage('P', 'A4');

$pdf->SetFont('montserrat', 'B', 12);
$pdf->Cell(0, 10, utf8_decode('CERTIFICACIÓN LABORAL'), 0, 1, 'C');

$pdf->SetFont('montserrat', '', 11);
$pdf->MultiCell(0, 10, utf8_decode('Señores ' . $destinatario), 0, 'L');
$pdf->Ln(10);

$pdf->SetFont('montserrat', 'B', 11);
$pdf->Cell(0, 10, 'DATABIZ S.A.S', 0, 1, 'C');
$pdf->SetFont('montserrat', '', 11);
$pdf->Cell(0, 10, 'NIT 900641482-1', 0, 1, 'C');
$pdf->Ln(2);

$pdf->SetFont('montserrat', 'B', 11);
$pdf->Cell(0, 10, 'HACE CONSTAR', 0, 1, 'C');
$pdf->Ln(4);

$pdf->SetFont('montserrat', '', 11);
$pdf->Write(10, utf8_decode('Que '));

$pdf->SetFont('montserrat', 'B', 11);
$pdf->Write(10, utf8_decode($nombre_completo));

$pdf->SetFont('montserrat', '', 11);
$pdf->Write(10, utf8_decode(' identificado(a) con cédula de ciudadanía No. '));

$pdf->SetFont('montserrat', 'B', 11);
$pdf->Write(10, utf8_decode($cedula));

$pdf->SetFont('montserrat', '', 11);
$pdf->Write(10, utf8_decode('labora en nuestra compañía desde el '));

$pdf->SetFont('montserrat', 'B', 11);
$pdf->Write(10, utf8_decode($fecha_ingreso));

$pdf->SetFont('montserrat', '', 11);
$pdf->Write(10, utf8_decode(' desempeñando el cargo de '));

$pdf->SetFont('montserrat', 'B', 11);
$pdf->Write(10, utf8_decode($cargo));

$pdf->SetFont('montserrat', '', 11);
$pdf->Write(10, utf8_decode(', con un contrato a término '));

$pdf->SetFont('montserrat', 'B', 11);
$pdf->Write(10, utf8_decode($tipo_contrato));

$pdf->SetFont('montserrat', '', 11);
$pdf->Write(10, utf8_decode(', devengando un salario básico mensual de ' ));

$pdf->SetFont('montserrat', 'B', 11);
$pdf->Write(10, utf8_decode('($' . $salario . ')'));

$pdf->SetFont('montserrat', '', 11);
$pdf->Write(10, utf8_decode(', más todas las prestaciones de ley.'));

$pdf->Ln(15);
$pdf->SetFont('montserrat', '', 11);
$pdf->Write(10, utf8_decode('          * Un auxilio mensual no salarial de '));

$pdf->SetFont('montserrat', 'B', 11);
$pdf->Write(10, utf8_decode('($' . $auxilio . ')'));

$pdf->Ln(15);

$pdf->SetFont('montserrat', '', 11);
$pdf->Write(10, utf8_decode('Para un total de '));

$pdf->SetFont('montserrat', 'B', 11);
$pdf->Write(10, utf8_decode('($' . $neto_pagar . ')'));

$pdf->Ln(15);

$pdf->SetFont('montserrat', '', 11);
$pdf->MultiCell(0, 10, 'Este certificado se expide el dia del mes del .', 0, 'L');
$pdf->Ln(10);
$pdf->MultiCell(0, 10, 'Sin otro particular,', 0, 'L');
$pdf->Ln(14);
$pdf->SetFont('montserrat', 'B', 11); // Negrilla
$pdf->Cell(0, 10, 'Lorena Acosta', 0, 'L');
$pdf->Ln(-4);
$pdf->MultiCell(0, 10, utf8_decode('Líder de Talento Humano'), 0, 'L');
$pdf->Ln(-4);
$pdf->MultiCell(0, 10, 'DATABIZ S.A.S', 0, 'L');

$pdf->Output($nombre_completo . ' ' . $cedula . '.pdf', 'I');
?>
