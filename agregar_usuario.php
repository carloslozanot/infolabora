<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Usuario</title>
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
    <div id="agregar-usuario">
        <?php
        if (isset($_POST['enviar'])) {

            include("php/conexion.php");

            // Obtener el último id actual
            $consulta = "SELECT MAX(id) AS ultimo_id FROM usuarios";
            $resultado_id = mysqli_query($conexion, $consulta);
            $fila = mysqli_fetch_assoc($resultado_id);
            $ultimo_id = $fila['ultimo_id'] ?? 0;
            $nuevo_id = $ultimo_id + 1;

            // Recoger los valores del formulario
            $cedula = $_POST['cedula'];
            $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
            $fecha = $_POST['fecha'];
            $rol = $_POST['rol'];

            // Validación básica de rol
            if (!is_numeric($rol)) {
                echo "<script>alert('Debe seleccionar un rol válido'); location.assign('index_admin.php');</script>";
                exit;
            }

            // Insertar nuevo usuario
            $sql = "INSERT INTO usuarios (id, cedula, contrasena, fecha_diligenciamiento, id_rol)
                    VALUES ($nuevo_id, $cedula, '$contrasena', '$fecha', $rol)";
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

            <h3>Fecha de Creación</h3>
            <input type="date" name="fecha" class="form-control"><br>

            <h3>Rol</h3>
            <select name="rol" class="form-control">
                <option value="">Seleccionar un rol</option>  
                <option value="2">Integrante</option>
                <option value="3">Talento Humano</option>
            </select> <br>

            <div class="botones-agregar-usuario">
                <button type="submit" class="btn btn-success" name="enviar">Agregar</button>
                <a href="index_admin.php" class="btn btn-danger">Regresar</a>
            </div>
        </form>
    </div>
</body>

</html>
