<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Rol</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="docs/css/estilos.css">
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
</head>

<body>
    <div id="agregar-rol">
        <?php

        if (isset($_POST['enviar'])) {
            $id = $_POST['id'];
            $descripcion = $_POST['descripcion'];

            include("php/conexion.php");
            $sql = "INSERT INTO permisos values('" . $id . "','" . $descripcion . "')";

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

        <div class="titulo-agregar-rol">
            <h1>Agregar Rol</h1>
        </div>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
            <h3>Id</h3>
            <input type="text" name="id" class="form-control"><br>

            <h3>Descripcion</h3>
            <input type="text" name="descripcion" class="form-control"><br>

            <div class="botones-agregar-rol">

                <button type="submit" class="btn btn-success" name="enviar">Agregar</button>
                <a href="index_admin.php" class="btn btn-danger">Regresar</a>

            </div>
    </div>
</body>

</html>