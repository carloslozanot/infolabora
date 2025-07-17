<?php
date_default_timezone_set('America/Bogota'); // Establece la zona horaria correcta

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cedula = $_POST['cedula'];
    $nueva = $_POST['nueva'];
    $confirmar = $_POST['confirmar'];

    // Verifica coincidencia
    if ($nueva !== $confirmar) {
        echo "<script>alert('Las contraseñas no coinciden.'); window.history.back();</script>";
        exit;
    }

    // Valida complejidad
    if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[^A-Za-z\d])[\w\W]{8,}$/', $nueva)) {
        echo "<script>alert('La contraseña debe tener al menos 8 caracteres, incluir letras, números y un carácter especial.'); window.history.back();</script>";
        exit;
    }

    include 'php/conexion.php';

    $hashed = password_hash($nueva, PASSWORD_DEFAULT);

    $stmt = $conexion->prepare("UPDATE usuarios SET contrasena = ? WHERE cedula = ?");
    $stmt->bind_param("ss", $hashed, $cedula);
    $stmt->execute();

    echo "<script>alert('Contraseña actualizada correctamente'); window.location.replace('index.php');</script>";

    $stmt->close();
    $conexion->close();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>CAMBIAR CONTRASEÑA</title>
    <link rel="stylesheet" href="docs/css/estilos.css">
</head>

<body class="body_index_login">
    <main>
        <style>
            .input-group {
                position: relative;
            }

            .toggle-password {
                position: absolute;
                right: 10px;
                top: 50%;
                transform: translateY(-50%);
                cursor: pointer;
                font-size: 18px;
                color: #666;
            }
        </style>

        <form method="POST" class="formulario_login" onsubmit="return validarFormulario()">
            <label style="display: block; text-align: center; font-weight: 700; font-size: 30px;">NUEVA CONTRASEÑA</label><br>

            <input type="hidden" name="cedula" value="<?= htmlspecialchars($_GET['cedula'] ?? '') ?>">

            <div class="input-group">
                <input type="password" id="nueva" name="nueva" placeholder="Nueva contraseña" required
                    pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[^A-Za-z\d]).{8,}$"
                    title="Mínimo 8 caracteres, con letras, números y un carácter especial.">
                <span class="toggle-password" onclick="togglePassword('nueva', this)">👁️</span>
            </div>

            <div class="input-group">
                <input type="password" id="confirmar" name="confirmar" placeholder="Confirmar contraseña" required>
                <span class="toggle-password" onclick="togglePassword('confirmar', this)">👁️</span>
            </div>

            <button type="submit"
                style="display: block; margin: 0 auto; margin-top: 20px; padding: 10px 20px; text-align: center; font-size: 16px; border-radius: 6px; cursor: pointer; font-weight: bold;">
                Cambiar Contraseña
            </button>
        </form>

        <script>
            function validarFormulario() {
                const nueva = document.getElementById('nueva').value;
                const confirmar = document.getElementById('confirmar').value;
                if (nueva !== confirmar) {
                    alert('Las contraseñas no coinciden.');
                    return false;
                }
                return true;
            }

            function togglePassword(id, icon) {
                const input = document.getElementById(id);
                if (input.type === "password") {
                    input.type = "text";
                    icon.textContent = "🙈";
                } else {
                    input.type = "password";
                    icon.textContent = "👁️";
                }
            }
        </script>

    </main>
</body>

</html>
