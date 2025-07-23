<?php
require('fpdf.php');

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, utf8_decode('DESPRENDIBLE DE PAGO'), 0, 1, 'C');
        $this->Ln(5);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
    }
}

session_start();

if (!isset($_POST['id']) || !isset($_POST['periodo'])) {
    die("Datos incompletos");
}

include("../php/conexion.php");

$cedula = $_POST['id'];
$periodo = $_POST['periodo'];

$query = "SELECT * FROM desprendibles d, integrantes i WHERE d.cedula = i.cedula AND d.cedula = '$cedula' AND periodo = '$periodo' LIMIT 1";
$resultado = mysqli_query($conexion, $query);

if (!$resultado || mysqli_num_rows($resultado) === 0) {
    die("No se encontraron datos para la cédula y periodo indicados.");
}

$datos = mysqli_fetch_assoc($resultado);

// Crear PDF
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 11);

// Datos del empleado
$pdf->SetFillColor(230, 230, 250);
$pdf->Cell(50, 8, 'Nombre:', 0, 0);
$pdf->Cell(140, 8, utf8_decode($datos['nombres']), 0, 1, 'L');
$pdf->Cell(50, 8, 'Cédula:', 0, 0);
$pdf->Cell(140, 8, $datos['cedula'], 0, 1, 'L');
$pdf->Cell(50, 8, 'Cargo:', 0, 0);
$pdf->Cell(140, 8, utf8_decode($datos['cargo']), 0, 1, 'L');
$pdf->Cell(50, 8, 'Periodo:', 0, 0);
$pdf->Cell(140, 8, $datos['periodo'], 0, 1, 'L');

$pdf->Ln(10);

// Encabezado tabla
$pdf->SetFont('Arial', 'B', 11);
$pdf->SetFillColor(220, 220, 220);
$pdf->Cell(100, 8, 'Concepto', 1, 0, 'C', true);
$pdf->Cell(45, 8, 'Ingreso', 1, 0, 'C', true);
$pdf->Cell(45, 8, 'Deducción', 1, 1, 'C', true);

$pdf->SetFont('Arial', '', 11);

// Obtener detalles
$query_detalle = "SELECT neto_pagar FROM desprendibles WHERE cedula = '$cedula' AND periodo = '$periodo'";
$resultado_detalle = mysqli_query($conexion, $query_detalle);

if ($resultado_detalle && mysqli_num_rows($resultado_detalle) > 0) {
    while ($item = mysqli_fetch_assoc($resultado_detalle)) {
        $ingreso = floatval(str_replace('.', '', $item['neto_pagar']));
        $deduccion = floatval(str_replace('.', '', $item['neto_pagar']));
        
        $pdf->Cell(100, 8, utf8_decode($item['neto_pagar']), 1);
        $pdf->Cell(45, 8, number_format($ingreso, 0, ',', '.'), 1, 0, 'R');
        $pdf->Cell(45, 8, number_format($deduccion, 0, ',', '.'), 1, 1, 'R');
    }
} else {
    $pdf->Cell(190, 8, 'No hay conceptos disponibles.', 1, 1, 'C');
}

$pdf->Ln(5);

// Totales
$total_ingresos = floatval(str_replace('.', '', $datos['total_ingresos']));
$total_deducciones = floatval(str_replace('.', '', $datos['total_deducciones']));
$neto = floatval(str_replace('.', '', $datos['neto']));

$pdf->SetFont('Arial', 'B', 11);
$pdf->SetFillColor(240, 240, 240);
$pdf->Cell(100, 8, 'Totales', 1, 0, 'R', true);
$pdf->Cell(45, 8, number_format($total_ingresos, 0, ',', '.'), 1, 0, 'R', true);
$pdf->Cell(45, 8, number_format($total_deducciones, 0, ',', '.'), 1, 1, 'R', true);

$pdf->Ln(8);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(210, 255, 210);
$pdf->Cell(190, 10, 'Neto a Pagar: $' . number_format($neto, 0, ',', '.'), 0, 1, 'C', true);

$pdf->Output();
?>
