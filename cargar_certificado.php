<?php
session_start();
include("php/conexion.php");

if (!isset($_SESSION['usuario'])) {
    echo '<p>Debe iniciar sesión.</p>';
    exit;
}

if (!isset($_GET['id'])) {
    die("No se recibió el ID del certificado");
}

$id = intval($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
        $nombreArchivo = basename($_FILES['archivo']['name']);
        $rutaDestino = "docs/documents/certificado_ing_ret/" . $nombreArchivo;

        // Crear carpeta si no existe
        if (!is_dir("uploads/certificados")) {
            mkdir("uploads/certificados", 0777, true);
        }

        if (move_uploaded_file($_FILES['archivo']['tmp_name'], $rutaDestino)) {
            $stmt = $conexion->prepare("UPDATE certificados SET valor = ? WHERE id = ?");
            $stmt->bind_param("si", $rutaDestino, $id);
            $stmt->execute();

            echo "<script>alert('Archivo cargado correctamente'); window.location='tupagina_certificados.php?cedula=".$_SESSION['usuario']."';</script>";
        } else {
            echo "<script>alert('Error al subir el archivo');</script>";
        }
    } else {
        echo "<script>alert('Seleccione un archivo válido');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cargar Certificado</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h3>Cargar Certificado</h3>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Seleccione el archivo</label>
            <input type="file" name="archivo" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Subir</button>
        <a href="tupagina_certificados.php?cedula=<?= $_SESSION['usuario'] ?>" class="btn btn-secondary">Cancelar</a>
    </form>
</body>
</html>
