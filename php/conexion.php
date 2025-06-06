<?php
// Mostrar errores para debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

$host = "infolaboradbsvr.mysql.database.azure.com";
$usuario = "adminlabora";
$contrasena = "D4t4b1z.2025";
$bd = "infolabora";

$conexion = new mysqli($host, $usuario, $contrasena, $bd);

if ($conexion->connect_error) {
    die("❌ Conexión fallida: " . $conexion->connect_error);
}
// No cerramos conexión aquí
?>
