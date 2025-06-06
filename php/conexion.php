<?php
$host = "infolaboradbsvr.mysql.database.azure.com"; // o la IP/host de tu servidor de BD
$usuario = "adminlabora@infolaboradbsvr.mysql.database.azure.com";
$contrasena = "D4t4b1z.2025";
$bd = "infolabora";

// Crear conexión
$conn = new mysqli($host, $usuario, $contrasena, $bd);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
} else {
    echo "✅ Conexión exitosa a la base de datos";
}

// Cerrar conexión (opcional aquí)
$conn->close();
?>