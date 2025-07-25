<?php
include("php/conexion.php");

if (isset($_GET['cedula']) && isset($_GET['periodo'])) {
    $cedula = $_GET['cedula'];
    $periodo = $_GET['periodo'];

    $sql = "SELECT dias_totales FROM vacaciones WHERE cedula = '$cedula' AND periodo = '$periodo' LIMIT 1";
    $result = mysqli_query($conexion, $sql);
    $data = mysqli_fetch_assoc($result);

    echo $data ? $data['dias_totales'] : 0;
}
?>
