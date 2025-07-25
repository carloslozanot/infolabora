<?php
include("php/conexion.php");

if (isset($_POST['cedula']) && isset($_POST['periodo'])) {
    $cedula = $_POST['cedula'];
    $periodo = $_POST['periodo'];

    $sql = "SELECT dias_totales FROM vacaciones WHERE cedula = '$cedula' AND periodo = '$periodo' LIMIT 1";
    $resultado = mysqli_query($conexion, $sql);
    $row = mysqli_fetch_assoc($resultado);

    echo $row['dias_totales'] ?? '0';
}
?>
