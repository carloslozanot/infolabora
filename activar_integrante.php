<?php

$cedula = $_GET['id'];
include("php/conexion.php");


$sql = "update integrantes set estado = 'Activo', fecha_retiro = NULL where cedula='" . $cedula . "'";
$resultado = mysqli_query($conexion, $sql);

if ($resultado) {
    echo "<script language='JavaScript'>
            alert('El usuario se ha activado correctamente');
            location.assign('index_th.php');
            </script>";
} else {
    echo "<script language='JavaScript'>
            alert('El usuario NO se ha activado correctamente');
            location.assign('index_th.php');
            </script>";
}
?>