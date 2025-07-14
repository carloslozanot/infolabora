<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cedula = $_POST["cedula"] ?? '';

    include 'conexion.php';

    $stmt = $conexion->prepare("SELECT correo FROM empleados WHERE cedula = ?");
    $stmt->bind_param("s", $cedula);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $correo = $row['correo'];
        $token = bin2hex(random_bytes(16));
        $enlace = "cambiar_contrasena.php?cedula=$cedula&token=$token";
        echo "<script>alert('Se envió un enlace de recuperación al correo: $correo'); window.location.href='index.php';</script>";
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
                <form action="recuperar_contrasena.php" method="POST" class="formulario_login">
                    <label style="display: block; text-align: center;font-weight: 800; font-size: 30px">Recuperar Contraseña</label><br>
                    <input type="text" name="cedula" placeholder="Ingresa tu número de cédula" required>
                    <button>Enviar enlace</button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>