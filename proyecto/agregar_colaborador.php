<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Colaborador</title>
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
    <div id="agregar-colaborador">
        <?php

        if (isset($_POST['enviar'])) {

            $cedula = $_POST['cedula'];
            $nombres = $_POST['nombres'];
            $apellidos = $_POST['apellidos'];
            $edad = $_POST['edad'];
            $celular = $_POST['celular'];
            $correo = $_POST['correo'];          
            $fecha_ingreso = $_POST['fecha_ingreso'];
            $cargo = $_POST['cargo'];
            $area = $_POST['area'];
            $jefe_inmediato = $_POST['jefe_inmediato'];
            $caja = $_POST['caja'];
            $eps = $_POST['eps'];
            $arl = $_POST['arl'];
            $pensiones = $_POST['pensiones'];
            $cesantias = $_POST['cesantias'];
            $imagen = $_POST['imagen'];

            include("php/conexion.php");
            $sql = "INSERT INTO empleados values
            ('','".$cedula."','".$nombres."','".$apellidos."','".$edad."','".$celular."','".$correo."'
            ,'".$fecha_ingreso."','".$cargo."','".$area."','".$jefe_inmediato."','".$caja."','".$eps."'
            ,'".$arl."','".$pensiones."','".$cesantias."','".$imagen."')";

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

        <div class="titulo-agregar-colaborador">
            <h1>Agregar Colaborador</h1>
        </div>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">

            <h3>Cedula*</h3>
            <input type="text" name="cedula" class="form-control"><br>

            <h3>Nombres*</h3>
            <input type="text" name="nombres" class="form-control"><br>

            <h3>Apellidos*</h3>
            <input type="text" name="apellidos" class="form-control"><br>

            <h3>Edad</h3>
            <input type="text" name="edad" class="form-control"><br>

            <h3>Celular</h3>
            <input type="text" name="celular" class="form-control"><br>

            <h3>Correo</h3>
            <input type="text" name="correo" class="form-control"><br>         
            
            <h3>Fecha Ingreso</h3>
            <input type="date" name="fecha_ingreso" class="form-control"><br>

            <h3>Cargo</h3>
            <input type="text" name="cargo" class="form-control"><br>

            <h3>Area</h3>
            <input type="text" name="area" class="form-control"><br>
            
            <h3>Jefe Inmediato</h3>
            <input type="text" name="jefe_inmediato" class="form-control"><br>

            <h3>Caja</h3>
            <input type="text" name="caja" class="form-control"><br>

            <h3>EPS</h3>
            <input type="text" name="eps" class="form-control"><br>

            <h3>ARL</h3>
            <input type="text" name="arl" class="form-control"><br>

            <h3>Pensiones</h3>
            <input type="text" name="pensiones" class="form-control"><br>

            <h3>Cesantias</h3>
            <input type="text" name="cesantias" class="form-control"><br>

            <h3>Imagen</h3>
            <input type="text" name="imagen" class="form-control"><br>

            <div class="botones-agregar-colaborador">

                <button type="submit" class="btn btn-success" name="enviar">Agregar</button>
                <a href="index_admin.php" class="btn btn-danger">Regresar</a>

            </div>
        </form>
    </div>
</body>

</html>