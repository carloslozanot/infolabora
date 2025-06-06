<?php

    session_start();

    if(isset($_SESSION['usuario'])){
        header("location: index_usuario.php");
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">


    <link rel="stylesheet" href="docs/css/estilos.css">
</head>
<body class= "body_index_login">

        <main >

            <div class="contenedor_todo">
                <!--Formulario de Login y registro-->
                <div class="contenedor_login-register">
                    <!--Login-->
                    <form action="php/index.php" method="POST" class="formulario_login">
                        <h2>Iniciar Sesión</h2>
                        <input type="text" placeholder="Numero de cedula" name="cedula">
                        <input type="password" placeholder="Contraseña" name="contrasena">
                        <button style="align: center;">Entrar</button>
                    </form>
                </div>
            </div>

        </main>

        <script src="docs/js/script.js"></script>
</body>
</html>