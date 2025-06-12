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
                <label style="display: block; text-align: center;font-weight: 1000; font-size: 50px">INFOLABORA</label><br>
                    <label style="display: block; text-align: center;font-weight: 700; font-size: 30px">INICIAR SESIÓN</label><br>
                    <input type="text" placeholder="Número de cédula" name="cedula" required>
                    <input type="password" placeholder="Contraseña" name="contrasena" required>
                    <button>Entrar</button>
                </form>
            </div>
        </div>
    </main>
    <script src="docs/js/script.js"></script>
</body>
</html>
