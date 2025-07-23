<?php
require('fpdf.php');

class PDF extends FPDF
{
    function Header()
    {
        // Logo
        $this->Image('../docs/img/logo.png', 10, 8, 30); // Ajusta la ruta y tamaño del logo
        // Título
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, utf8_decode('DESPRENDIBLE DE PAGO'), 0, 1, 'C');
        $this->Ln(10);
    }

    function Footer()
    {
        $this->SetY(-20);
        $this->SetFont('Arial', 'I', 8);
        $this->MultiCell(0, 5, utf8_decode("Este documento es confidencial y contiene información sobre los pagos realizados. Verifique cualquier inconsistencia con el área de Talento Humano."), 0, 'C');
    }

    function DatosEmpleado($empleado)
    {
        $this->SetFont('Arial', '', 10);
        foreach ($empleado as $key => $value) {
            $this->Cell(50, 8, utf8_decode($key), 0, 0);
            $this->Cell(80, 8, utf8_decode($value), 0, 1);
        }
        $this->Ln(5);
    }

    function TablaConceptos($conceptos)
    {
        $this->SetFillColor(220, 220, 220);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(80, 8, utf8_decode('CONCEPTO'), 1, 0, 'C', true);
        $this->Cell(40, 8, 'INGRESOS', 1, 0, 'C', true);
        $this->Cell(40, 8, 'DEDUCCIONES', 1, 1, 'C', true);

        $this->SetFont('Arial', '', 10);
        foreach ($conceptos as $item) {
            $this->Cell(80, 8, utf8_decode($item['concepto']), 1);
            $this->Cell(40, 8, number_format($item['ingreso'], 0, ',', '.'), 1, 0, 'R');
            $this->Cell(40, 8, number_format($item['deduccion'], 0, ',', '.'), 1, 1, 'R');
        }
    }

    function Totales($ingresoTotal, $deduccionTotal)
    {
        $neto = $ingresoTotal - $deduccionTotal;
        $this->Ln(5);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(120, 8, 'TOTAL INGRESOS:', 0, 0, 'R');
        $this->Cell(40, 8, number_format($ingresoTotal, 0, ',', '.'), 0, 1, 'R');

        $this->Cell(120, 8, 'TOTAL DEDUCCIONES:', 0, 0, 'R');
        $this->Cell(40, 8, number_format($deduccionTotal, 0, ',', '.'), 0, 1, 'R');

        $this->SetFont('Arial', 'B', 12);
        $this->SetTextColor(0, 102, 0);
        $this->Cell(120, 8, 'NETO A PAGAR:', 0, 0, 'R');
        $this->Cell(40, 8, number_format($neto, 0, ',', '.'), 0, 1, 'R');
    }
}

// =====================
// Simulación de datos
// =====================
$empleado = [
    'Nombre:' => 'Carlos Pérez',
    'Cédula:' => '12345678',
    'Cargo:' => 'Analista',
    'Área:' => 'Financiera',
    'Periodo:' => 'Enero-2025'
];

$conceptos = [
    ['concepto' => 'Salario básico', 'ingreso' => 2000000, 'deduccion' => 0],
    ['concepto' => 'Subsidio transporte', 'ingreso' => 140000, 'deduccion' => 0],
    ['concepto' => 'Salud', 'ingreso' => 0, 'deduccion' => 160000],
    ['concepto' => 'Pensión', 'ingreso' => 0, 'deduccion' => 160000],
];

$ingresos = array_sum(array_column($conceptos, 'ingreso'));
$deducciones = array_sum(array_column($conceptos, 'deduccion'));

// =====================
// Generar PDF
// =====================
$pdf = new PDF();
$pdf->AddPage();
$pdf->DatosEmpleado($empleado);
$pdf->TablaConceptos($conceptos);
$pdf->Totales($ingresos, $deducciones);
$pdf->Output();
?>
