<?php
include("php/conexion.php");

$radicado = $_GET['id'];
$accion = $_GET['accion'];

if ($accion === 'aprobar') {
    $consulta = "SELECT cedula, dias, periodo FROM solicitudes WHERE radicado = '$radicado'";
    $resultado = mysqli_query($conexion, $consulta);
    $row = mysqli_fetch_assoc($resultado);

    $cedula = $row['cedula'];
    $dias_solicitados = (int) $row['dias'];
    $periodo = $row['periodo'];

    $consulta2 = "SELECT dias_disfrutados, dias_dinero, dias_totales 
                  FROM vacaciones 
                  WHERE cedula = '$cedula' AND periodo = '$periodo'";
    $resultado2 = mysqli_query($conexion, $consulta2);
    $row2 = mysqli_fetch_assoc($resultado2);

    $dias_actuales = $row2 ? (int) $row2['dias_disfrutados'] : 0;
    $dias_dinero = $row2 ? (int) $row2['dias_dinero'] : 0;
    $dias_totales = $row2 ? (int) $row2['dias_totales'] : 0;

    $nuevo_disfrute = $dias_actuales + $dias_solicitados;

    // 1. Aprobar esta solicitud
    $sql = "UPDATE solicitudes SET estado = 'Aprobadas' WHERE radicado = '$radicado'";
    mysqli_query($conexion, $sql);

    // 2. Actualizar los días disfrutados
    $sql_2 = "UPDATE vacaciones 
              SET dias_disfrutados = '$nuevo_disfrute' 
              WHERE cedula = '$cedula' AND periodo = '$periodo'";
    mysqli_query($conexion, $sql_2);

    // 3. Verificar si ya se completaron los días totales
    if (($nuevo_disfrute + $dias_dinero) >= $dias_totales) {
        // Rechazar todas las demás solicitudes pendientes del mismo periodo
        $sql_3 = "UPDATE solicitudes 
                  SET estado = 'Rechazadas' 
                  WHERE cedula = '$cedula' 
                  AND periodo = '$periodo' 
                  AND radicado != '$radicado'";
        mysqli_query($conexion, $sql_3);
    }

} elseif ($accion === 'rechazar') {
    $sql = "UPDATE solicitudes SET estado = 'Rechazadas' WHERE radicado = '$radicado'";
    mysqli_query($conexion, $sql);
}

header("Location: ../index_th.php?mensaje=ok");
exit;
?>