<?php
include("php/conexion.php");

// Verificar si se ha enviado un archivo
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["documento"])) {
    $nombreArchivo = $_FILES["documento"]["name"];
    $rutaTemporal = $_FILES["documento"]["tmp_name"];
    $rutaDestino = "C:\\xampp\\htdocs\\proyecto\\docs\\documents\\ausentismos\\" . $nombreArchivo;

    // Mover el archivo a la carpeta de destino
    if (move_uploaded_file($rutaTemporal, $rutaDestino)) {
        echo "El archivo $nombreArchivo se ha subido correctamente.";
    } else {
        echo "Ha ocurrido un error al subir el archivo.";
    }
} else {
    echo "No se ha cargado ningún archivo.";
}
?>
