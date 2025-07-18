<?php

$cedula = $_GET['id'];
include("php/conexion.php");


$sql = "update integrantes set estado = 'Inactivo' where cedula='" . $cedula . "'";
$resultado = mysqli_query($conexion, $sql);

if ($resultado) {
    echo "<script language='JavaScript'>
            alert('El usuario se ha deshabilitado correctamente');
            location.assign('index_admin.php');
            </script>";
} else {
    echo "<script language='JavaScript'>
            alert('El usuario NO se ha deshabilitado correctamente');
            location.assign('index_admin.php');
            </script>";
}
?>