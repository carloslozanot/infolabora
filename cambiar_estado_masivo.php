<?php
include("php/conexion.php");

$accion = $_POST['accion'] ?? '';
$cedulas = $_POST['cedulas'] ?? [];

if (!in_array($accion, ['activar', 'desactivar']) || empty($cedulas)) {
    exit('Acción no válida o sin selección');
}

$estado = ($accion === 'activar') ? 'Activo' : 'Inactivo';

foreach ($cedulas as $cedula) {
    $cedula = mysqli_real_escape_string($conexion, $cedula);
    mysqli_query($conexion, "UPDATE integrantes SET estado='$estado' WHERE cedula='$cedula'");
}

echo "ok";
