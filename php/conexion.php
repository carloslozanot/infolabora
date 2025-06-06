<?php
$host = "infolaboradbsvr.mysql.database.azure.com";
$usuario = "adminlabora";
$contrasena = "D4t4b1z.2025";
$bd = "infolabora";

$conn = new mysqli($host, $usuario, $contrasena, $bd);

if ($conn->connect_error) {
    die("❌ Conexión fallida: " . $conn->connect_error);
}

// No cierres la conexión aquí 👇
// $conn->close();
?>
