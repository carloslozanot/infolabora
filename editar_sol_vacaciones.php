<?php
include("php/conexion.php");

$radicado = $_GET['id'];
$accion = $_GET['accion'];

if ($accion === 'aprobar') {
    $sql = "UPDATE solicitudes SET estado = 'Aprobadas' WHERE radicado = '$radicado'";
} elseif ($accion === 'rechazar') {
    $sql = "UPDATE solicitudes SET estado = 'Rechazadas' WHERE radicado = '$radicado'";
}

if (mysqli_query($conexion, $sql)) {
    header("Location: ../index_th.php");
} else {
    echo "Error al actualizar: " . mysqli_error($conexion);
}
?>
