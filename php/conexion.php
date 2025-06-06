<?php

// Parámetros de conexión para Azure MySQL
$server = "infolabora.azurewebsites.net"; // usualmente termina en .mysql.database.azure.com
$user = "adminlabora@infolabora.azurewebsites.net"; // el usuario incluye @nombre del servidor
$password = "D4t4b1z.2025";
$database = "infolabora"; // o el nombre de tu BD

$conexion = mysqli_connect($server, $user, $password, $database);

if ($conexion) {
    echo 'Conectado a la base de datos';
} else {
    echo 'Error de conexión: ' . mysqli_connect_error();
}

?>