<?php
session_start();
include("php/conexion.php");

$cedula = $_GET['cedula'] ?? '';
$periodo = $_GET['periodo'] ?? '';

if ($cedula != '' && $periodo != '') {
    $sql = "SELECT dias_totales, dias_disfrutados, dias_dinero 
            FROM vacaciones 
            WHERE cedula = '$cedula' AND periodo = '$periodo'";
    $result = mysqli_query($conexion, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $dias_totales = floatval($row['dias_totales']);
        $dias_disfrutados = floatval($row['dias_disfrutados']);
        $dias_dinero = floatval($row['dias_dinero']);

        // Si dias_totales es 0, usar dias_generados de la sesión
        if ($dias_totales <= 0) {
            $dias_totales = floatval($_SESSION['dias_generados'] ?? 0);
        }

        $dias_faltantes = $dias_totales - $dias_disfrutados - $dias_dinero;

        echo json_encode([
            'dias_totales' => $dias_totales,
            'dias_disfrutados' => $dias_disfrutados,
            'dias_dinero' => $dias_dinero,
            'dias_faltantes' => $dias_faltantes
        ]);
    } else {
        // No hay registro en BD, usar dias_generados de la sesión
        $generados = floatval($_SESSION['dias_generados'] ?? 0);
        echo json_encode([
            'dias_totales' => $generados,
            'dias_disfrutados' => 0,
            'dias_dinero' => 0,
            'dias_faltantes' => $generados
        ]);
    }
} else {
    echo json_encode([
        'dias_totales' => 0,
        'dias_disfrutados' => 0,
        'dias_dinero' => 0,
        'dias_faltantes' => 0
    ]);
}
?>