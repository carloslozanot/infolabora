<?php
session_start();
include("php/conexion.php");

$cedula = $_GET['cedula'] ?? '';
$periodo = $_GET['periodo'] ?? '';

$response = [
    'dias_totales' => 0,
    'dias_disfrutados' => 0,
    'dias_dinero' => 0,
    'dias_faltantes' => 0
];

if (!empty($cedula) && !empty($periodo)) {
    $sql = "SELECT dias_totales, dias_disfrutados, dias_dinero 
            FROM vacaciones 
            WHERE cedula = '$cedula' AND periodo = '$periodo' 
            LIMIT 1";
    $resultado = mysqli_query($conexion, $sql);

    if ($resultado && $row = mysqli_fetch_assoc($resultado)) {
        $dias_totales = floatval($row['dias_totales']);
        $dias_disfrutados = floatval($row['dias_disfrutados']);
        $dias_dinero = floatval($row['dias_dinero']);
        $faltantes = $dias_totales - $dias_disfrutados - $dias_dinero;

        // Si faltantes es 0 o negativo, usar la variable de sesión
        if ($faltantes = 0) {
            $faltantes = $_SESSION['dias_generados'];
        }

        $response = [
            'dias_totales' => $dias_totales,
            'dias_disfrutados' => $dias_disfrutados,
            'dias_dinero' => $dias_dinero,
            'dias_faltantes' => $faltantes
        ];
    }
}

echo json_encode($response);
