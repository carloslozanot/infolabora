<?php

$cedula = $_GET['id'];
include("php/conexion.php");


$sql = "delete from empleados where cedula='" . $cedula . "'";
$resultado = mysqli_query($conexion, $sql);

if ($resultado) {
    echo "<script language='JavaScript'>
            alert('Los datos se han eliminaron correctamente');
            location.assign('index_admin.php');
            </script>";
} else {
    echo "<script language='JavaScript'>
            alert('Los datos NO se han eliminaron correctamente');
            location.assign('index_admin.php');
            </script>";
}
?>