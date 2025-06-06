<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Rol</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0/css/bootstrap.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="docs/css/estilos.css">
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
</head>

<body>
    <div id="agregar-usuario">
        <?php

        if (isset($_POST['enviar'])) {

            $cedula = $_POST['cedula'];
            $contrasena = $_POST['contrasena'];
            $fecha = $_POST['fecha'];
            $rol = $_POST['rol'];

            include("php/conexion.php");
            $sql = "INSERT INTO usuarios values('','" . $cedula . "','" . $contrasena . "','" . $fecha . "','" . $rol . "')";

            $resultado = mysqli_query($conexion, $sql);

            if ($resultado) {
                echo "<script language='JavaScript'>
                    alert('Los datos se han creado correctamente');
                    location.assign('index_admin.php');
                    </script>";
            } else {
                echo "<script language='JavaScript'>
                    alert('Los datos NO se han creado correctamente');
                    location.assign('index_admin.php');
                    </script>";
            }

            mysqli_close($conexion);
        }

        ?>

        <div class="titulo-agregar-usuario">
            <h1>Agregar Usuario</h1>
        </div>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">

            <h3>Usuario</h3>
            <input type="text" name="cedula" class="form-control"><br>

            <h3>Contraseña</h3>
            <input type="text" name="contrasena" class="form-control"><br>

            <h3>Fecha de Creacion</h3>
            <input type="date" name="fecha" class="form-control"><br>

            <h3>Rol</h3>
            <select name="rol" class="form-control">
                <option>Seleccionar un rol</option>  
                <option value="2">Colaborador</option>
                <option value="3">Recursos Humanos</option>
            </select> <br>

            <div class="botones-agregar-usuario">

                <button type="submit" class="btn btn-success" name="enviar">Agregar</button>
                <a href="index_admin.php" class="btn btn-danger">Regresar</a>

            </div>
        </form>
    </div>
</body>

</html>