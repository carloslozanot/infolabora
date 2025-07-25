<?php
include("php/conexion.php");

$cedula = $_GET['cedula'] ?? '';
$periodo = $_GET['periodo'] ?? '';

if ($cedula && $periodo) {
    $sql = "SELECT dias_totales FROM vacaciones WHERE cedula = '$cedula' AND periodo = '$periodo' LIMIT 1";
    $resultado = mysqli_query($conexion, $sql);

    if ($row = mysqli_fetch_assoc($resultado)) {
        echo $row['dias_totales'];
    } else {
        echo '0';
    }
} else {
    echo '0';
}
?>
