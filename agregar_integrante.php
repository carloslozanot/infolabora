<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Integrante</title>
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
    <div id="agregar-integrante">
        <?php
        if (isset($_POST['enviar'])) {
            include("php/conexion.php");

            $consulta = "SELECT MAX(id_integrante) AS ultimo_id FROM integrantes";
            $resultado_id = mysqli_query($conexion, $consulta);
            $fila = mysqli_fetch_assoc($resultado_id);
            $ultimo_id = $fila['ultimo_id'] ?? 0;
            $nuevo_id = $ultimo_id + 1;

            // 2. Recoger datos del formulario
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
            $estado = $_POST['estado'];

            $sql = "INSERT INTO integrantes (
                        id_integrante, cedula, nombres, apellidos, edad, celular, correo,
                        fecha_ingreso, cargo, area, lider_inmediato,
                        caja, eps, arl, pensiones, cesantias, imagen, direccion, ciudad_residencia, tipo_contrato, estado, fecha_retiro
                    ) VALUES (
                        $nuevo_id, '$cedula', '$nombres', '$apellidos', '$edad', '$celular', '$correo',
                        '$fecha_ingreso', '$cargo', '$area', '$lider_inmediato', '$caja', '$eps', '$arl', 
                        '$pensiones', '$cesantias', '$imagen', '$direccion', '$ciudad_residencia', '$tipo_contrato',
                        '$estado', NULL
                    )";

            $resultado = mysqli_query($conexion, $sql);

            // 4. Verificación
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

        <div class="titulo-agregar-integrante">
            <h1>Agregar Integrante</h1>
        </div>

        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">

            <h3>Cédula*</h3>
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

            <h3>Fecha de ingreso</h3>
            <input type="date" name="fecha_ingreso" class="form-control"><br>

            <h3>Dirección</h3>
            <input type="text" name="direccion" class="form-control"><br>

            <h3>Ciudad de residencia</h3>
            <input type="text" name="ciudad_residencia" class="form-control"><br>

            <h3>Cargo</h3>
            <input type="text" name="cargo" class="form-control"><br>

            <h3>Área</h3>
            <input type="text" name="area" class="form-control"><br>

            <h3>Tipo de contrato</h3>
            <input type="text" name="tipo_contrato" class="form-control"><br>

            <h3>Líder Inmediato</h3>
            <input type="text" name="lider_inmediato" class="form-control"><br>

            <h3>Caja de compensación</h3>
            <input type="text" name="caja" class="form-control"><br>

            <h3>EPS</h3>
            <select name="eps" class="form-control">
                <?php
                include("php/conexion.php");

                $consulta = "SELECT valor FROM parametros WHERE tipo = 'EPS'";
                $resultado = mysqli_query($conexion, $consulta);

                while ($fila = mysqli_fetch_assoc($resultado)) {
                    echo '<option value="' . $fila['valor'] . '">' . $fila['valor'] . '</option>';
                }
                ?>
            </select><br>


            <h3>ARL</h3>
            <input type="text" name="arl" class="form-control"><br>

            <h3>Pensiones</h3>
            <input type="text" name="pensiones" class="form-control"><br>

            <h3>Cesantías</h3>
            <input type="text" name="cesantias" class="form-control"><br>

            <h3>Imagen</h3>
            <input type="text" name="imagen" class="form-control"><br>

            <h3>Estado</h3>
            <select name="estado" class="form-control">
                <option value="Activo">Activo</option>
                <option value="Inactivo">Inactivo</option>
            </select>


            <h3>Fecha de retiro</h3>
            <input type="text" name="fecha_retiro" class="form-control" value="<?php echo $fecha_retiro ?>"
                disabled><br>

            <div class="botones-agregar-integrante">
                <button type="submit" class="btn btn-success" name="enviar">Agregar</button>
                <a href="index_admin.php" class="btn btn-danger">Regresar</a>
            </div>
        </form>
    </div>
</body>

</html>