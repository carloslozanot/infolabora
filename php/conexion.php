<?php
// Mostrar errores
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Datos de conexión
$host = "infolaboradbsvr.mysql.database.azure.com";
$usuario = "adminlabora";
$contrasena = "D4t4b1z.2025";
$bd = "infolabora";

// Crear conexión
$conexion = new mysqli($host, $usuario, $contrasena, $bd);

// Verificar conexión
if ($conexion->connect_error) {
    die("❌ Conexión fallida: " . $conexion->connect_error);
}
?>
