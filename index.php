<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Login</title>
    <link rel="stylesheet" href="docs/css/estilos.css" />
</head>
<body class="body_index_login">
    <main>
        <div class="contenedor_todo">
            <div class="contenedor_login-register">
                <form action="php/login_usuario.php" method="POST" class="formulario_login">
                    <h2>Iniciar Sesión</h2>
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
