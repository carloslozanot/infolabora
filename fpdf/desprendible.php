<?php
require('fpdf.php');

$cedula = isset($_POST['id']) ? $_POST['id'] : '';
$periodo = isset($_POST['periodo']) ? $_POST['periodo'] : '';

include("../php/conexion.php");
$consulta_info = $conexion->query("SELECT * FROM desprendibles d, integrantes i WHERE d.cedula = i.cedula AND d.cedula = '$cedula' AND d.periodo = '$periodo'");

if ($consulta_info->num_rows > 0) {
    $dato = $consulta_info->fetch_object();

    // Limpieza de valores numéricos
    function limpiar_numero($valor) {
        return number_format(floatval(str_replace('.', '', str_replace(',', '', $valor))), 0, ',', '.');
    }

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);

    // Título
    $pdf->Cell(0, 10, utf8_decode('DESPRENDIBLE DE PAGO'), 0, 1, 'C');
    $pdf->Ln(5);

    // Información del empleado
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(95, 8, utf8_decode('Nombre: ' . $dato->nombre_completo), 0, 0);
    $pdf->Cell(95, 8, utf8_decode('Cédula: ' . $dato->cedula), 0, 1);
    $pdf->Cell(95, 8, utf8_decode('Cargo: ' . $dato->cargo), 0, 0);
    $pdf->Cell(95, 8, utf8_decode('Periodo: ' . $dato->periodo), 0, 1);
    $pdf->Ln(5);

    // Devengados
    $pdf->SetFont('Arial', 'B', 13);
    $pdf->Cell(0, 8, utf8_decode('DEVENGADOS'), 0, 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(95, 8, 'Sueldo Básico: $' . limpiar_numero($dato->sueldo_basico), 0, 0);
    $pdf->Cell(95, 8, 'Días Trabajados: ' . $dato->dias_trabajados, 0, 1);
    $pdf->Cell(95, 8, 'Devengado: $' . limpiar_numero($dato->devengado), 0, 0);
    $pdf->Cell(95, 8, 'Auxilio Transporte: $' . limpiar_numero($dato->auxilio_transporte), 0, 1);
    $pdf->Cell(95, 8, 'Otros Devengados: $' . limpiar_numero($dato->otros_devengados), 0, 0);
    $pdf->Cell(95, 8, 'Total Devengado: $' . limpiar_numero($dato->total_devengado), 0, 1);
    $pdf->Ln(5);

    // Descuentos
    $pdf->SetFont('Arial', 'B', 13);
    $pdf->Cell(0, 8, utf8_decode('DESCUENTOS'), 0, 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(95, 8, 'Aportes EPS: $' . limpiar_numero($dato->aportes_eps), 0, 0);
    $pdf->Cell(95, 8, 'Aportes Pensión: $' . limpiar_numero($dato->aportes_pension), 0, 1);
    $pdf->Cell(95, 8, 'Total Descuentos: $' . limpiar_numero($dato->total_descuento), 0, 1);
    $pdf->Ln(5);

    // Neto pagado
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->SetFillColor(230, 230, 230);
    $pdf->Cell(0, 10, 'NETO PAGADO: $' . limpiar_numero($dato->neto_pagado), 0, 1, 'C', true);

    $pdf->Output();
} else {
    echo "No se encontró información para el periodo seleccionado.";
}
?>
