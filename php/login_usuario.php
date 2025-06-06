<?php
// php/login_usuario.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir datos del formulario
    $cedula = isset($_POST['cedula']) ? $_POST['cedula'] : '';
    $contrasena = isset($_POST['contrasena']) ? $_POST['contrasena'] : '';

    // Mostrar resultado simple
    echo "Hola: cédula = " . htmlspecialchars($cedula) . " y contraseña = " . htmlspecialchars($contrasena);
} else {
    // Si no es POST, redirigir o mostrar mensaje
    echo "Método no permitido";
}
?>
