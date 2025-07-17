<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cedula = $_POST["cedula"] ?? '';

    include 'php/conexion.php';

    $stmt = $conexion->prepare("SELECT correo FROM integrantes WHERE cedula = ?");
    $stmt->bind_param("s", $cedula);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $correo = $row['correo'];
        $token = bin2hex(random_bytes(16));
        echo "<script>window.location.href='cambiar_contrasena.php?cedula=$cedula&token=$token';</script>";
    } else {
        echo "<script>alert('No se encontró un usuario con esa cédula.'); window.location.href='recuperar_contrasena.php';</script>";
    }

    $stmt->close();
    $conexion->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Contraseña</title>
    <link rel="stylesheet" href="docs/css/estilos.css">
</head>
<body class="body_index_login">
    <main>
        <div class="contenedor_todo">
            <div class="contenedor_login-register">
                <form method="POST" class="formulario_login">
                    <label style="display: block; text-align: center;font-weight: 700; font-size: 30px">RECUPERAR CONTRASEÑA</label><br>
                    <input type="text" name="cedula" placeholder="Ingresa tu número de cédula" required>
                    <button type="submit" style="display: block;
                    margin: 0 auto;
                    margin-top: 20px;
                    padding: 10px 20px;
                    text-align: center;
                    font-size: 16px;
                    border-radius: 6px;
                    cursor: pointer;
                    font-weight: bold;">
                        Enviar Enlace
                    </button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>