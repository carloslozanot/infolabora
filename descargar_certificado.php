<?php
session_start();
include("php/conexion.php");

// Verificar que se recibieron datos
if (!isset($_POST['cedula'], $_POST['ano'])) {
    die("Solicitud inválida.");
}

$cedula = mysqli_real_escape_string($conexion, $_POST['cedula']);
$ano = mysqli_real_escape_string($conexion, $_POST['ano']);

// Consultar la ruta del archivo en la base
$sql = "SELECT Valor FROM certificados WHERE cedula = '$cedula' AND año = '$ano' AND tipo = 'Ingresos y Retenciones' LIMIT 1";
$result = mysqli_query($conexion, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $rutaArchivo = $row['Valor'];

    // Verificar que el archivo existe en el servidor
    if (file_exists($rutaArchivo)) {
        // Forzar descarga del archivo
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($rutaArchivo) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($rutaArchivo));
        flush();
        readfile($rutaArchivo);
        exit;
    } else {
        die("Archivo no encontrado en el servidor.");
    }
} else {
    die("No se encontró el certificado solicitado.");
}
?>
