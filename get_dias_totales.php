<?php
include("php/conexion.php");

$cedula = $_GET['cedula'] ?? '';
$periodo = $_GET['periodo'] ?? '';

if ($cedula && $periodo) {
    $sql = "SELECT dias_totales, dias_disfrutados, dias_dinero 
            FROM vacaciones 
            WHERE cedula = '$cedula' AND periodo = '$periodo' 
            LIMIT 1";
    $resultado = mysqli_query($conexion, $sql);

    if ($row = mysqli_fetch_assoc($resultado)) {
        echo json_encode([
            'dias_totales' => $row['dias_totales'],
            'dias_disfrutados' => $row['dias_disfrutados'],
            'dias_dinero' => $row['dias_dinero']
        ]);
    } else {
        echo json_encode([
            'dias_totales' => 0,
            'dias_disfrutados' => 0,
            'dias_dinero' => 0
        ]);
    }
} else {
    echo json_encode([
        'dias_totales' => 0,
        'dias_disfrutados' => 0,
        'dias_dinero' => 0
    ]);
}
?>
