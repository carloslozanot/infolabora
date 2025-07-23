<?php
require('fpdf.php');
session_start();
include("../php/conexion.php");

$cedula = $_POST['id'];
$periodo = $_POST['periodo'];

// Consulta los datos del desprendible
$query = "SELECT * FROM desprendibles WHERE cedula = '$cedula' AND periodo = '$periodo' LIMIT 1";
$resultado = mysqli_query($conexion, $query);
$datos = mysqli_fetch_assoc($resultado);

if (!$datos) {
    die('No se encontró información para el desprendible.');
}

class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, utf8_decode('COLILLA DE PAGO'), 0, 1, 'C');
        $this->Ln(5);
    }

    function Titulo($texto)
    {
        $this->SetFont('Arial', 'B', 12);
        $this->SetFillColor(230, 230, 230);
        $this->Cell(0, 8, utf8_decode($texto), 0, 1, 'L', true);
    }

    function LineaTexto($titulo, $valor, $negrita = false)
    {
        $this->SetFont('Arial', $negrita ? 'B' : '', 11);
        $this->Cell(60, 8, utf8_decode($titulo), 0, 0, 'L');
        $this->Cell(0, 8, utf8_decode($valor), 0, 1, 'L');
    }

    function TablaConceptos($titulo, $conceptos)
    {
        $this->SetFont('Arial', 'B', 11);
        $this->SetFillColor(240, 240, 240);
        $this->Cell(95, 8, utf8_decode($titulo), 1, 0, 'L', true);
        $this->Cell(0, 8, utf8_decode('Valor'), 1, 1, 'R', true);

        $this->SetFont('Arial', '', 11);
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
$pdf->LineaTexto('Nombre:', 'CIFUENTES & URIBE SAS');
$pdf->LineaTexto('NIT:', '800.113.238');

$pdf->Ln(2);
$pdf->Titulo('EMPLEADO');
$pdf->LineaTexto('Nombre:', utf8_decode($datos['aportes_pension']));
$pdf->LineaTexto('C.C.:', $datos['cedula']);
$pdf->LineaTexto('Cargo:', utf8_decode($datos['cargo']));

$pdf->Ln(2);
$pdf->Titulo('PERIODO DE PAGO');
$pdf->LineaTexto('Periodo:', substr($datos['periodo'], 4, 2) . '/01/' . substr($datos['periodo'], 0, 4));  // Ej: 202501 → 01/01/2025
$pdf->LineaTexto('Días trabajados:', $datos['aportes_pension']);
$pdf->LineaTexto('Salario Base:', '$ ' . number_format(normalizar_num($datos['aportes_pensión']), 0, ',', '.'));

// Resumen del pago
$pdf->Ln(4);
$pdf->Titulo('RESUMEN DEL PAGO');

$pdf->TablaConceptos('Item', [
    'Salario' => normalizar_num($datos['aportes_pension']),
    'Subsidio de Transporte' => normalizar_num($datos['aportes_pension']),
    'Ingresos adicionales' => normalizar_num($datos['aportes_pension']),
    'Retenciones y deducciones' => -normalizar_num($datos['aportes_pension']),
    'TOTAL NETO A PAGAR AL EMPLEADO' => normalizar_num($datos['aportes_pension']) + normalizar_num($datos['aportes_pensión']) + normalizar_num($datos['aportes_pensión']) - normalizar_num($datos['aportes_pensión'])
]);

// Ingresos adicionales
$pdf->Ln(4);
$pdf->Titulo('INGRESOS ADICIONALES');

$pdf->TablaConceptos('Concepto', [
    'Comisiones' => normalizar_num($datos['aportes_pension']),
    'Auxilio de movilización' => normalizar_num($datos['aportes_pension']),
]);

// Retenciones y deducciones
$pdf->Ln(4);
$pdf->Titulo('RETENCIONES Y DEDUCCIONES');

$pdf->TablaConceptos('Concepto', [
    'Salud 4%' => normalizar_num($datos['aportes_eps']),
    'Pensión 4%' => normalizar_num($datos['aportes_pension']),
    'Total Retenciones' => normalizar_num($datos['aportes_pension']),
]);

$pdf->Ln(10);
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(0, 6, utf8_decode("Sara Catalina Corredor Rodriguez\nCC. 1.015.479.959\n\nCIFUENTES & URIBE SAS\nNIT. 800.113.238-3\n\nSoftware de recursos humanos, seguridad social y nómina.\nwww.aleluya.com"), 0, 'C');

$pdf->Output();
