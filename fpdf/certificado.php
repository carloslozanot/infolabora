<?php
require('fpdf.php');

$cedula = isset($_POST['id']) ? $_POST['id'] : '';
$destinatario = isset($_POST['destinatario']) ? $_POST['destinatario'] : '';

// Realizar la consulta a la base de datos
include("../php/conexion.php");
$consulta_info = $conexion->query("select * from desprendibles where cedula = '$cedula'");

if ($consulta_info->num_rows > 0) {
   $dato_info = $consulta_info->fetch_object();
   $nombre_completo = $dato_info->nombre_completo;
   $cargo = $dato_info->cargo;
   $neto_pagar = $dato_info->neto_pagar;
   $fecha_ingreso = $dato_info->fecha_ingreso;

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
      global $destinatario;
      global $nombre_completo;
      global $fecha_ingreso;
      global $neto_pagar;
      global $cargo;

    $this->SetFont('Arial', '', 11);  

    $this->MultiCell(0, 10, 'Senores '.$destinatario, 0, 'L');
    $this->Ln(10); 

    $this->SetFont('Arial', 'B', 11);
    $this->SetTextColor(0); // Establece el color del texto a negro
    $this->Cell(0, 10, 'DATABIZ S.A.S', 0, 1, 'C'); // Alinea el texto al centro
    $this->Ln(-4); // Reducido el espacio entre líneas
    $this->SetFont('Arial', '', 11); // Cambia la fuente a normal
    $this->Cell(0, 10, 'NIT 12345678-9', 0, 1, 'C');
    $this->Ln(2);

      // Configuración de la fuente y alineación
    $this->SetFont('Arial', 'B', 11);
    $this->SetTextColor(0); // Establece el color del texto a negro
    $this->Cell(0, 10, 'HACE CONSTAR', 0, 1, 'C'); // Alinea el texto al centro
    $this->Ln(4); 

    // Restaurar la configuración predeterminada de la fuente
    $this->SetFont('Arial', '', 11);

    $this->MultiCell(0, 10, 'Que '.$nombre_completo.' identificado(a) con cedula de ciudadania No. '.$cedula.', labora en nuestra compania desde el '.$fecha_ingreso.', desempenando el cargo de '.$cargo.', con un contrato a termino '.$cargo.', mas todas las prestaciones de ley. ', 0, 'L');
    $this->MultiCell(0, 10, '*  Devengando un salario total neto de '.$neto_pagar.'', 0, 'L');
    $this->Ln(5);
    $this->MultiCell(0, 10, 'Este certificado se expide a solicitud del interesado para los fines que estime conveniente.', 0, 'L');
    $this->Ln(14);

    $this->MultiCell(0, 10, 'Carlos Andres Lozano Torres', 0, 'L');
    $this->Ln(-4);
    $this->MultiCell(0, 10, 'Lider de Talento Humano', 0, 'L');
    $this->Ln(-4);
    $this->MultiCell(0, 10, 'DATABIZ S.A.S', 0, 'L');

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

$pdf->Output($nombre_completo.'  '.$cedula.'.pdf', 'I');
?>
