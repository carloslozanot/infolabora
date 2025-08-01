<?php

include("php/conexion.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
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
    <div id="editar-usuario">
        <?php
        include("php/conexion.php");

        if (isset($_POST['enviar'])) {
            $cedula = $_POST['cedula'];
            $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
            $permiso = $_POST['permiso'];

            $sql = "UPDATE usuarios SET contrasena = '" . $contrasena . "', id_permiso = '" . $permiso . "' WHERE cedula = '" . $cedula . "'";
            $resultado = mysqli_query($conexion, $sql);

            if ($resultado) {
                echo "<script language='JavaScript'>
            alert('Los datos se han actualizado correctamente');
            location.assign('index_admin.php');
        </script>";
            } else {
                echo "<script language='JavaScript'>
            alert('No se han actualizado correctamente');
            location.assign('index_admin.php');
        </script>";
            }
            mysqli_close($conexion);

        } else {
            $cedula = $_GET['id'];
            $sql = "SELECT * FROM usuarios u, integrantes e, permisos r WHERE u.cedula = e.cedula AND u.id_permiso = r.id AND u.cedula='" . $cedula . "'";
            $resultado = mysqli_query($conexion, $sql);

            $fila = mysqli_fetch_assoc($resultado);
            $cedula = $fila["cedula"];
            $contrasena = $fila["contrasena"];
            $descripcion = $fila["descripcion"];

            mysqli_close($conexion);

        }
        ?>

        <div class="titulo-editar-usuario">
        <p style="font-size: 36px; font-weight:700;">EDITAR USUARIO<br></p>
        </div>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">

            <h3>Usuario</h3>
            <input type="text" name="cedula" class="form-control" value="<?php echo $cedula ?>"><br>

            <h3>Contraseña</h3>
            <input type="text" name="contrasena" class="form-control" value="<?php echo $contrasena ?>"><br>

            <h3>Permiso</h3>
            <select name="permiso" class="form-control">
                <?php
                if ($descripcion === 'Integrante') {
                    echo '<option value="2">Integrante</option>
                            <option value="3">Talento Humano</option>';
                } elseif ($descripcion === 'Talento Humano') {
                    echo '<option value="3">Talento Humano</option>
                            <option value="2">Integrante</option>';
                }
                ?>
            </select><br>

            <input type="hidden" name="cedula" value="<?php echo $cedula ?>">

            <div class="botones-editar-usuario">
                <button type="submit" class="btn btn-success" name="enviar">Editar</button>
                <a href="index_admin.php" class="btn btn-danger">Regresar</a>
            </div>
        </form>
    </div>
</body>

</html>