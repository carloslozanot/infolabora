<?php
include("php/conexion.php");

$radicado = $_GET['id'];
$accion = $_GET['accion'];

if ($accion === 'aprobar') {
    $consulta = "SELECT cedula, dias, periodo FROM solicitudes WHERE radicado = '$radicado'";
    $resultado = mysqli_query($conexion, $consulta);
    $row = mysqli_fetch_assoc($resultado);

    $cedula = $row['cedula'];
    $dias_solicitados = (int)$row['dias'];
    $periodo = $row['periodo'];

    $consulta2 = "SELECT dias_disfrutados FROM vacaciones WHERE cedula = '$cedula' AND periodo = '$periodo'";
    $resultado2 = mysqli_query($conexion, $consulta2);
    $row2 = mysqli_fetch_assoc($resultado2);
    $dias_actuales = $row2 ? (int)$row2['dias_disfrutados'] : 0;

    $dias_totales = $dias_actuales + $dias_solicitados;

    $sql = "UPDATE solicitudes SET estado = 'Aprobadas' WHERE radicado = '$radicado'";

    $sql_2 = "UPDATE vacaciones SET dias_disfrutados = '$dias_totales' WHERE cedula = '$cedula' AND periodo = '$periodo'";

    mysqli_query($conexion, $sql_2);
} elseif ($accion === 'rechazar') {
    $sql = "UPDATE solicitudes SET estado = 'Rechazadas' WHERE radicado = '$radicado'";
}

if (mysqli_query($conexion, $sql)) {
    header("Location: ../index_th.php?mensaje=ok");
} else {
    echo "Error al actualizar: " . mysqli_error($conexion);
}
?>
