<?php
require('fpdf.php');
session_start();
include("../php/conexion.php");

$cedula = $_POST['id'];
$periodo = $_POST['periodo'];

// Consulta los datos del desprendible
$query = "SELECT * FROM desprendibles d, integrantes i WHERE d.cedula = i.cedula AND d.cedula = '$cedula' AND periodo = '$periodo' LIMIT 1";
$resultado = mysqli_query($conexion, $query);
$datos = mysqli_fetch_assoc($resultado);

if (!$datos) {
    die('No se encontró información para el desprendible.');
}

class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, utf8_decode('DESPRENDIBLE DE PAGO'), 0, 1, 'C');
        $this->Ln(5);
    }

    function Titulo($texto)
    {
        $this->SetFont('Arial', 'B', 11);
        $this->SetFillColor(230, 230, 230);
        $this->Cell(0, 8, utf8_decode($texto), 0, 1, 'L', true);
    }

    function LineaTexto($titulo, $valor, $negrita = false)
    {
        $this->SetFont('Arial', $negrita ? 'B' : '', 10);
        $this->Cell(60, 8, utf8_decode($titulo), 0, 0, 'L');
        $this->Cell(0, 8, utf8_decode($valor), 0, 1, 'L');
    }

    function TablaConceptos($titulo, $conceptos)
    {
        $this->SetFont('Arial', 'B', 10);
        $this->SetFillColor(240, 240, 240);
        $this->Cell(95, 8, utf8_decode($titulo), 1, 0, 'L', true);
        $this->Cell(0, 8, utf8_decode('Valor'), 1, 1, 'R', true);

        $this->SetFont('Arial', '', 10);
        foreach ($conceptos as $nombre => $valor) {
            $this->Cell(95, 8, utf8_decode($nombre), 1);
            $this->Cell(0, 8, '$ ' . number_format($valor, 0, ',', '.'), 1, 1, 'R');
        }
    }
}

function normalizar_num($valor) {
    return floatval(str_replace(['.', ','], ['', '.'], $valor));
}

$pdf = new PDF();
$pdf->AddPage();

// Empresa y empleado
$pdf->Titulo('EMPRESA');
$pdf->LineaTexto('Nombre:', 'Empresa');
$pdf->LineaTexto('NIT:', '123.456.789');

$pdf->Ln(2);
$pdf->Titulo('EMPLEADO');
$pdf->LineaTexto('Nombre:', utf8_decode($datos['nombres']));
$pdf->LineaTexto('C.C.:', $datos['cedula']);
$pdf->LineaTexto('Cargo:', utf8_decode($datos['cargo']));

$pdf->Ln(2);
$pdf->Titulo('PERIODO DE PAGO');
$pdf->LineaTexto('Periodo:', substr($datos['periodo'], 4, 2) . '/01/' . substr($datos['periodo'], 0, 4));  // Ej: 202501 → 01/01/2025
$pdf->LineaTexto('Días trabajados:', $datos['dias_trabajados']);
$pdf->LineaTexto('Salario Base:', '$ ' . number_format(normalizar_num($datos['sueldo_basico']), 0, ',', '.'));

// Resumen del pago
$pdf->Ln(4);
$pdf->Titulo('RESUMEN DEL PAGO');

$pdf->TablaConceptos('Item', [
    'Salario' => normalizar_num($datos['sueldo_basico']),
    'Subsidio de Transporte' => normalizar_num($datos['auxilio_transporte']),
    'Ingresos adicionales' => normalizar_num($datos['aportes_pension']),
    'Retenciones y deducciones' => -normalizar_num($datos['aportes_pension']),
    'TOTAL NETO A PAGAR AL EMPLEADO' => normalizar_num($datos['neto_pagar']) + normalizar_num($datos['aportes_pension']) + normalizar_num($datos['aportes_pension']) - normalizar_num($datos['aportes_pension'])
]);

// Ingresos adicionales
$pdf->Ln(4);
$pdf->Titulo('INGRESOS ADICIONALES');

$pdf->TablaConceptos('Concepto', [
    'Comisiones' => normalizar_num($datos['aportes_pension']),
    'Auxilio de movilización' => normalizar_num($datos['auxilio_transporte']),
]);

// Retenciones y deducciones
$pdf->Ln(4);
$pdf->Titulo('RETENCIONES Y DEDUCCIONES');

$pdf->TablaConceptos('Concepto', [
    'Salud 4%' => normalizar_num($datos['aportes_eps']),
    'Pensión 4%' => normalizar_num($datos['aportes_pension']),
    'Total Retenciones' => normalizar_num($datos['total_descuento']),
]);

$pdf->Output();
