<?php
require('fpdf/fpdf.php');
include("php/conexion.php");

if (!isset($_GET['cedula']) && !isset($cedula)) return;
$cedula = isset($cedula) ? intval($cedula) : intval($_GET['cedula']);

$sql = "SELECT * FROM integrantes WHERE cedula = $cedula LIMIT 1";
$res = mysqli_query($conexion, $sql);

if (!$res || mysqli_num_rows($res) === 0) return;

$datos = mysqli_fetch_assoc($res);

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

$pdf->Cell(0, 10, utf8_decode('Certificado de Referencia'), 0, 1, 'C');
$pdf->Ln(10);

$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(0, 10, utf8_decode("Se certifica que el(la) señor(a): {$datos['nombres']} {$datos['apellidos']}, identificado(a) con cédula No. {$datos['cedula']}, laboró en la empresa en el cargo de {$datos['cargo']} desde el {$datos['fecha_ingreso']}."), 0, 'L');

$pdf->Ln(10);
$pdf->Cell(0, 10, 'Fecha de emisión: ' . date('Y-m-d'), 0, 1, 'L');

$ruta = "temp/certificado_{$cedula}.pdf";
$pdf->Output('F', $ruta);
?>
