<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <title>Login</title>
    <link rel="stylesheet" href="docs/css/estilos.css" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;900&display=swap" rel="stylesheet">
</head>

<body class="body_index_login">
    <main>
        <div class="contenedor_todo">
            <div class="contenedor_login-register">
                <form action="php/login_usuario.php" method="POST" class="formulario_login">
                    <label
                        style="display: block; text-align: center;font-weight: 800; font-size: 40px">INFOLABORA</label><br>
                    <label style="display: block; text-align: center;font-weight: 600; font-size: 25px">INICIAR
                        SESIÓN</label><br>
                    <input type="text" placeholder="Número de cédula" name="cedula" required>
                    <input type="password" placeholder="Contraseña" name="contrasena" required>
                    <button type="submit" style="display: block;
                    margin: 0 auto;
                    margin-top: 20px;
                    padding: 10px 20px;
                    text-align: center;
                    font-size: 16px;
                    cursor: pointer;
                    font-weight: bold;">
                        Entrar
                    </button>
                    <br>
                    <a href="recuperar_contrasena.php"
                        style="display: block; text-align: center; margin-top: 10px; color: #007bff; text-decoration: none;">
                        ¿Olvidaste tu contraseña?
                    </a>
                </form>

            </div>
        </div>
    </main>
    <script src="docs/js/script.js"></script>
</body>

</html>