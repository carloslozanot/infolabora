<?php

session_start();

include 'conexion.php';


$cedula = mysqli_real_escape_string($conexion, $_POST['cedula']);
$contrasena = mysqli_real_escape_string($conexion, $_POST['contrasena']);

?>

