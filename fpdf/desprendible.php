<?php
require('fpdf.php');

$cedula = isset($_POST['id']) ? $_POST['id'] : '';
$mes = isset($_POST['mes']) ? $_POST['mes'] : '';

// Realizar la consulta a la base de datos
include("../php/conexion.php");
$consulta_info = $conexion->query("select * from desprendibles where cedula = '$cedula' and mes = '$mes'");

if ($consulta_info->num_rows > 0) {
   $dato_info = $consulta_info->fetch_object();
   $nombre_completo = $dato_info->nombre_completo;
   $cargo = $dato_info->cargo;
   $sueldo_basico = $dato_info->sueldo_basico;
   $dias_trabajados = $dato_info->dias_trabajados;
   $devengado = $dato_info->devengado;
   $auxilio_transporte = $dato_info->auxilio_transporte;
   $otros_devengados = $dato_info->otros_devengados;
   $total_devengado = $dato_info->total_devengado;
   $aportes_eps = $dato_info->aportes_eps;
   $aportes_pension = $dato_info->aportes_pension;
   $total_descuento = $dato_info->total_descuento;
   $neto_pagar = $dato_info->neto_pagar;

} else {
   $nombre_completo = "No disponible";
   $cargo = "No disponible"; // O proporciona un valor predeterminado si no se encontraron resultados
}

class PDF extends FPDF
{
   function NoResultsMessage()
   {
      $this->SetFont('Arial', 'B', 14);
      $this->SetTextColor(255, 0, 0);
      $this->Cell(0, 20, utf8_decode('No se encontraron resultados para la consulta.'), 0, 1, 'C');
   }

   // Cabecera de página
   function Header()
   {
      global $cedula;
      global $mes;
      global $nombre_completo;
      global $cargo;

      $this->SetFont('Arial', 'B', 18);
      $this->Cell(20);
      $this->SetTextColor(0, 0, 0);
      $this->Cell(110, 15, utf8_decode("DATABIZ S.A.S"), 1, 1, 'C', 0);
      $this->Ln(3);
      $this->SetTextColor(103);

      if ($nombre_completo !== "No disponible") {
         $this->SetTextColor(0, 0, 0);
         $this->Cell(20);
         $this->SetFont('Arial', 'B', 10);
         $this->Cell(96, 10, utf8_decode("NOMBRE TRABAJADOR : $nombre_completo"), 0, 0, '', 0);
         $this->Ln(5);
         $this->Cell(20);
         $this->SetFont('Arial', 'B', 10);
         $this->Cell(96, 10, utf8_decode("IDENTIFICACION : $cedula"), 0, 0, '', 0);
         $this->Ln(5);
         $this->Cell(20);
         $this->SetFont('Arial', 'B', 10);
         $this->Cell(96, 10, utf8_decode("CARGO : $cargo"), 0, 0, '', 0);
         $this->Ln(10);
      } else {
         $this->NoResultsMessage();
      }
      
      $this->SetFont('Arial', 'B', 18);
      $this->Cell(20);
      $this->Cell(110, 15, utf8_decode("DESPRENDIBLE DE PAGO"), 1, 1, 'C', 0);
      $this->Ln(3);
      $this->SetTextColor(103);
      
      $this->Cell(34);
      $this->SetFont('Arial', 'B', 10);
      $this->Cell(50, 10, utf8_decode("Periodo correspondiente al mes de " . $mes), 0, 0, '', 0);
      $this->Ln(10);

   }

   // Pie de página
   function Footer()
   {
      $this->SetY(-15);
      $this->SetFont('Arial', 'I', 8);
      $this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
   }
}

// Crear una instancia de PDF
$pdf = new PDF();
$pdf->AddPage('P', array(160, 200));

// Define el ancho de las columnas y la altura de las filas
$colWidth1 = 30;
$colWidth2 = 70;
$rowHeight = 10;

$data = [
   ['SUELDO BASICO', $sueldo_basico],
   ['DIAS TRABAJADOS', $dias_trabajados],
   ['DEVENGADO', $devengado],
   ['AUXILIO DE TRANSPORTE', $auxilio_transporte],
   ['OTROS DEVENGADOS', $otros_devengados],
   ['TOTAL DEVENGADO', $total_devengado],
   ['APORTES EPS', $aportes_eps],
   ['APORTES PENSION', $aportes_pension],
   ['TOTAL DESCUENTOS', '-' . $total_descuento],
   ['NETO A PAGAR', $neto_pagar],
];

$centerX = ($pdf->GetPageWidth() - ($colWidth1 + $colWidth2)) / 2;

// Generar la tabla
foreach ($data as $key => $row) {
   $pdf->SetX($centerX);

   $pdf->SetFont('Arial', 'B', 11);
   $pdf->Cell($colWidth1, $rowHeight, $row[0], 0);

   if (in_array($key, [5, 8, 9])) {
      $pdf->SetFont('Arial', 'B', 11);
   } else {
      $pdf->SetFont('Arial', '', 11);
   }
   $pdf->Cell($colWidth2, $rowHeight, $row[1], 0, 1, 'R');
}

$pdf->Output($nombre_completo.'  '.$cedula.'.pdf', 'I');
?>