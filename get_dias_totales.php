<?php
session_start();
include("php/conexion.php");

$cedula = $_GET['cedula'] ?? '';
$periodo = $_GET['periodo'] ?? '';

if ($cedula !== '' && $periodo !== '') {
    $sql = "SELECT dias_totales, dias_disfrutados, dias_dinero 
            FROM vacaciones 
            WHERE cedula = '$cedula' AND periodo = '$periodo'";
    $result = mysqli_query($conexion, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $dias_totales = intval($row['dias_totales']);
        $dias_disfrutados = intval($row['dias_disfrutados']);
        $dias_dinero = intval($row['dias_dinero']);

        if ($dias_totales === 0) {
            $dias_totales = intval($_SESSION['dias_generados'] ?? 0);
        }

        $dias_faltantes = $dias_totales - $dias_disfrutados - $dias_dinero;

        echo json_encode([
            'dias_totales' => $dias_totales,
            'dias_disfrutados' => $dias_disfrutados,
            'dias_dinero' => $dias_dinero,
            'dias_faltantes' => $dias_faltantes
        ]);
    } else {
        // Si no hay registro para ese período, usamos solo lo que hay en la sesión
        $dias_generados = intval($_SESSION['dias_generados'] ?? 0);
        echo json_encode([
            'dias_totales' => $dias_generados,
            'dias_disfrutados' => 0,
            'dias_dinero' => 0,
            'dias_faltantes' => $dias_generados
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
