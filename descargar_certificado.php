<?php
session_start();
include("php/conexion.php");

// Validar datos recibidos por GET
if (!isset($_GET['cedula'], $_GET['ano'])) {
    die("Solicitud inválida.");
}

$cedula = mysqli_real_escape_string($conexion, $_GET['cedula']);
$ano = mysqli_real_escape_string($conexion, $_GET['ano']);

$sql = "SELECT Valor FROM certificados WHERE cedula = '$cedula' AND año = '$ano' AND tipo = 'Ingresos y Retenciones' LIMIT 1";
$result = mysqli_query($conexion, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $rutaArchivo = $row['Valor'];

    if (file_exists($rutaArchivo)) {
        // Obtener extensión para setear Content-Type adecuado
        $ext = pathinfo($rutaArchivo, PATHINFO_EXTENSION);
        $mimeTypes = [
            'pdf' => 'application/pdf',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            // agrega más si necesitas
        ];

        $contentType = $mimeTypes[strtolower($ext)] ?? 'application/octet-stream';

        header('Content-Type: ' . $contentType);
        header('Content-Disposition: inline; filename="' . basename($rutaArchivo) . '"');
        header('Content-Length: ' . filesize($rutaArchivo));
        readfile($rutaArchivo);
        exit;
    } else {
        die("Archivo no encontrado.");
    }
} else {
    die("No se encontró el certificado.");
}
