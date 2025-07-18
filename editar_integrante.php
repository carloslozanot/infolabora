<?php

include("php/conexion.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Integrante</title>
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
    <div id="editar-integrante">
        <?php
        include("php/conexion.php");

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
            $lider_inmediato = $_POST['lider_inmediato'];
            $caja = $_POST['caja'];
            $eps = $_POST['eps'];
            $arl = $_POST['arl'];
            $pensiones = $_POST['pensiones'];
            $cesantias = $_POST['cesantias'];
            $imagen = $_POST['imagen'];
            $direccion = $_POST['direccion'];
            $ciudad_residencia = $_POST['ciudad_residencia'];
            $tipo_contrato = $_POST['tipo_contrato'];

            $sql = "UPDATE integrantes 
                    SET cedula = '" . $cedula . "', nombres = '" . $nombres . "', apellidos = '" . $apellidos . "', edad = '" . $edad . "',
                    celular = '" . $celular . "', correo = '" . $correo . "', fecha_ingreso = '" . $fecha_ingreso . "', cargo = '" . $cargo . "',
                    area = '" . $area . "', lider_inmediato = '" . $lider_inmediato . "', caja = '" . $caja . "', eps = '" . $eps . "', arl = '" . $arl . "',
                    pensiones = '" . $pensiones . "', cesantias = '" . $cesantias . "', imagen = '" . $imagen . "', direccion = '" . $direccion . "', 
                    ciudad_residencia = '" . $ciudad_residencia . "', tipo_contrato = '" . $tipo_contrato . "'
                    WHERE cedula='" . $cedula . "'";
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
            $sql = "SELECT * FROM usuarios u, integrantes e WHERE u.cedula = e.cedula AND u.cedula='" . $cedula . "'";
            $resultado = mysqli_query($conexion, $sql);

            $fila = mysqli_fetch_assoc($resultado);

            $cedula = $fila['cedula'];
            $nombres = $fila['nombres'];
            $apellidos = $fila['apellidos'];
            $edad = $fila['edad'];
            $celular = $fila['celular'];
            $correo = $fila['correo'];
            $fecha_ingreso = $fila['fecha_ingreso'];
            $cargo = $fila['cargo'];
            $area = $fila['area'];
            $lider_inmediato = $fila['lider_inmediato'];
            $caja = $fila['caja'];
            $eps = $fila['eps'];
            $arl = $fila['arl'];
            $pensiones = $fila['pensiones'];
            $cesantias = $fila['cesantias'];
            $imagen = $fila['imagen'];
            $direccion = $fila['direccion'];
            $ciudad_residencia = $fila['ciudad_residencia'];
            $tipo_contrato = $fila['tipo_contrato'];
            $estado = $fila['estado'];
            $fecha_retiro = $fila['fecha_retiro'];

            mysqli_close($conexion);

        }
        ?>

        <div class="titulo-editar-integrante">
            <p style="font-size: 36px; font-weight:700;">EDITAR INTEGRANTE<br></p>
        </div>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">

            <h3>Cedula</h3>
            <input type="text" name="cedula" class="form-control" value="<?php echo $cedula ?>"><br>

            <h3>Nombres</h3>
            <input type="text" name="nombres" class="form-control" value="<?php echo $nombres ?>"><br>

            <h3>Apellidos</h3>
            <input type="text" name="apellidos" class="form-control" value="<?php echo $apellidos ?>"><br>

            <h3>Edad</h3>
            <input type="text" name="edad" class="form-control" value="<?php echo $edad ?>"><br>

            <h3>Celular</h3>
            <input type="text" name="celular" class="form-control" value="<?php echo $celular ?>"><br>

            <h3>Correo</h3>
            <input type="text" name="correo" class="form-control" value="<?php echo $correo ?>"><br>

            <h3>Fecha Ingreso</h3>
            <input type="date" name="fecha_ingreso" class="form-control" value="<?php echo $fecha_ingreso ?>"><br>

            <h3>Dirección</h3>
            <input type="text" name="direccion" class="form-control" value="<?php echo $direccion ?>"><br>

            <h3>Ciudad Residencia</h3>
            <input type="text" name="ciudad_residencia" class="form-control"
                value="<?php echo $ciudad_residencia ?>"><br>

            <h3>Cargo</h3>
            <input type="text" name="cargo" class="form-control" value="<?php echo $cargo ?>"><br>

            <h3>Área</h3>
            <input type="text" name="area" class="form-control" value="<?php echo $area ?>"><br>

            <h3>Tipo Contrato</h3>
            <input type="text" name="tipo_contrato" class="form-control" value="<?php echo $tipo_contrato ?>"><br>

            <h3>Lider Inmediato</h3>
            <input type="text" name="lider_inmediato" class="form-control" value="<?php echo $lider_inmediato ?>"><br>

            <h3>Caja</h3>
            <input type="text" name="caja" class="form-control" value="<?php echo $caja ?>"><br>

            <h3>EPS</h3>
            <input type="text" name="eps" class="form-control" value="<?php echo $eps ?>"><br>

            <h3>ARL</h3>
            <input type="text" name="arl" class="form-control" value="<?php echo $arl ?>"><br>

            <h3>Pensiones</h3>
            <input type="text" name="pensiones" class="form-control" value="<?php echo $pensiones ?>"><br>

            <h3>Cesantias</h3>
            <input type="text" name="cesantias" class="form-control" value="<?php echo $cesantias ?>"><br>

            <h3>Imagen</h3>
            <input type="text" name="imagen" class="form-control" value="<?php echo $imagen ?>"><br>

            <h3>Estado</h3>
            <input type="text" name="estado" class="form-control" value="<?php echo $estado ?>" disabled><br>

            <h3>Fecha Retiro</h3>
            <input type="text" name="fecha_retiro" class="form-control" value="<?php echo $fecha_retiro ?>" disabled><br>

            <input type="hidden" name="cedula" value="<?php echo $cedula ?>">

            <div class="botones-editar-integrante">
                <button type="submit" class="btn btn-success" name="enviar">Editar</button>
                <a href="index_admin.php" class="btn btn-danger">Regresar</a>
            </div>
        </form>
    </div>
</body>

</html>