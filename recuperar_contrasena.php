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
    <title>Cambiar Contraseña</title>
    <link rel="stylesheet" href="docs/css/estilos.css"> <!-- Mantener esta ruta correcta -->
    <style>
        .input-group {
            position: relative;
            margin-bottom: 15px;
        }

        .input-group input {
            width: 100%;
            padding-right: 35px;
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

        .formulario_login button {
            background-color: #007bff;
            color: white;
            border: none;
        }

        label {
            text-align: center;
            display: block;
            font-weight: 700;
            font-size: 28px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body class="body_index_login">
    <main>
        <form method="POST" class="formulario_login" onsubmit="return validarFormulario()">
            <label>NUEVA CONTRASEÑA</label>

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

            <button type="submit">Cambiar Contraseña</button>
        </form>
    </main>

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
</body>

</html>
