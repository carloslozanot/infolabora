<?php
require('fpdf.php');
include('../php/conexion.php');

// Recibir datos
$cedula = $_POST['id'];
$periodo = $_POST['periodo'];

// Consultar datos del empleado
$queryEmpleado = "SELECT nombres, cargo, area FROM integrantes WHERE cedula = '$cedula'";
$resultEmpleado = mysqli_query($conexion, $queryEmpleado);
$empleado = mysqli_fetch_assoc($resultEmpleado);

// Consultar datos del desprendible
$queryDesprendible = "SELECT * FROM desprendibles WHERE cedula = '$cedula' AND periodo = '$periodo'";
$resultDesprendible = mysqli_query($conexion, $queryDesprendible);
$datos = mysqli_fetch_assoc($resultDesprendible);

// Convertir periodo a formato: Enero-2025
$anio = substr($periodo, 0, 4);
$mes = substr($periodo, 4, 2);
$meses = ['01'=>'Enero','02'=>'Febrero','03'=>'Marzo','04'=>'Abril','05'=>'Mayo','06'=>'Junio',
          '07'=>'Julio','08'=>'Agosto','09'=>'Septiembre','10'=>'Octubre','11'=>'Noviembre','12'=>'Diciembre'];
$periodoFormateado = $meses[$mes] . ' - ' . $anio;

// Crear PDF
$pdf = new FPDF();
$pdf->AddPage();

// Encabezado
$pdf->SetFont('Arial','B',14);
$pdf->Cell(190,10,'EMPRESA XYZ S.A.S',0,1,'C');
$pdf->SetFont('Arial','',12);
$pdf->Cell(190,7,'Desprendible de Pago - '.$periodoFormateado,0,1,'C');
$pdf->Ln(5);

// Datos del empleado
$pdf->SetFont('Arial','',11);
$pdf->Cell(95,6,'Nombre: ' . $empleado['nombres'],0,0);
$pdf->Cell(95,6,'Cédula: ' . $cedula,0,1);
$pdf->Cell(95,6,'Cargo: ' . $empleado['cargo'],0,0);
$pdf->Cell(95,6,'Área: ' . $empleado['area'],0,1);
$pdf->Ln(8);

// Encabezado de tabla
$pdf->SetFillColor(220,220,220);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(100,8,'Concepto',1,0,'C',true);
$pdf->Cell(45,8,'Ingresos',1,0,'C',true);
$pdf->Cell(45,8,'Deducciones',1,1,'C',true);

// Filas de conceptos
$pdf->SetFont('Arial','',10);

// Ejemplo: puedes adaptar según tus columnas reales en la tabla
$conceptos = [
    ['Sueldo Básico', $datos['sueldo_basico'], 0],
    ['Auxilio Transporte', $datos['auxilio_transporte'], 0],
    ['Salud', 0, $datos['aportes_eps']],
    ['Pensión', 0, $datos['aportes_pension']]
];

foreach ($conceptos as $item) {
    $pdf->Cell(100,8,$item[0],1);
    $pdf->Cell(45,8,number_format($item[1],0,',','.'),1,0,'R');
    $pdf->Cell(45,8,number_format($item[2],0,',','.'),1,1,'R');
}

// Totales
$pdf->SetFont('Arial','B',11);
$pdf->Cell(100,8,'Totales',1,0,'R',true);
$pdf->Cell(45,8,number_format($datos['total_ingresos'],0,',','.'),1,0,'R',true);
$pdf->Cell(45,8,number_format($datos['total_deducciones'],0,',','.'),1,1,'R',true);

// Neto a pagar
$pdf->Ln(5);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(190,10,'Neto a Pagar: $'.number_format($datos['neto'],0,',','.'),0,1,'C');

// Pie de página
$pdf->SetY(-20);
$pdf->SetFont('Arial','I',9);
$pdf->Cell(0,10,utf8_decode('Este documento es generado electrónicamente y no requiere firma.'),0,0,'C');

$pdf->Output();
?>
