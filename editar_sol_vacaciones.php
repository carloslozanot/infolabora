<?php
include("php/conexion.php");

$radicado = $_GET['id'];
$accion = $_GET['accion'];

if ($accion === 'aprobar') {
    // Obtener los días solicitados desde la tabla solicitudes
    $consulta = "SELECT cedula, dias FROM solicitudes WHERE radicado = '$radicado'";
    $resultado = mysqli_query($conexion, $consulta);
    $row = mysqli_fetch_assoc($resultado);
    $cedula = $row['cedula'];
    $dias_solicitados = $row['dias'];

    // Obtener los días disfrutados actuales desde vacaciones
    $consulta2 = "SELECT dias_disfrutados FROM vacaciones WHERE cedula = '$cedula'";
    $resultado2 = mysqli_query($conexion, $consulta2);
    $row2 = mysqli_fetch_assoc($resultado2);
    $dias_actuales = $row2 ? $row2['dias_disfrutados'] : 0;

    // Sumar los días
    $dias_totales = $dias_actuales + $dias_solicitados;

    // Actualizar estado en solicitudes
    $sql = "UPDATE solicitudes SET estado = 'Aprobadas' WHERE radicado = '$radicado'";

    // Actualizar días disfrutados en vacaciones
    $sql_2 = "UPDATE vacaciones SET dias_disfrutados = '$dias_totales' WHERE cedula = '$cedula'";

    // Ejecutar ambas actualizaciones
    mysqli_query($conexion, $sql_2);
} elseif ($accion === 'rechazar') {
    $sql = "UPDATE solicitudes SET estado = 'Rechazadas' WHERE radicado = '$radicado'";
}

// Ejecutar actualización de estado y redirigir
if (mysqli_query($conexion, $sql)) {
    header("Location: ../index_th.php");
} else {
    echo "Error al actualizar: " . mysqli_error($conexion);
}
?>
