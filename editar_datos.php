<?php
session_start();

include("php/conexion.php");

$permiso = $_SESSION['permiso'] ?? null;

if ($permiso == '1') {
    $destino = 'index_admin.php';
} else {
    $destino = 'index_th.php';
}

if (isset($_GET['cedula'])) {
    $cedula = intval($_GET['cedula']);
} else {
    die("No se recibió la cédula");
}

?>


<!DOCTYPE html>
<html lang="es">

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
            location.assign('$destino');
        </script>";
            } else {
                echo "<script language='JavaScript'>
            alert('No se han actualizado correctamente');
            location.assign('$destino');
        </script>";
            }
            mysqli_close($conexion);

        } else {
            $cedula = $_GET['cedula'];
            $sql = "SELECT * 
            FROM usuarios u, integrantes e
            WHERE u.cedula = e.cedula 
            AND u.cedula='" . $cedula . "'";
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

        <div class="card shadow">
            <div class="card-header text-white" style="background-color: #150940">
                <h3 class="mb-0 titulo-banner">
                    <i class="fas fa-users"></i> EDITAR DATOS PERSONALES
                </h3>
            </div>
            <div class="card-body">
                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">CÉDULA</label>
                            <input type="text" name="cedula" class="form-control" value="<?php echo $cedula ?>"><br>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">NOMBRES</label>
                            <input type="text" name="nombres" class="form-control" value="<?php echo $nombres ?>"><br>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">APELLIDOS</label>
                            <input type="text" name="apellidos" class="form-control"
                                value="<?php echo $apellidos ?>"><br>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">EDAD</label>
                            <input type="text" name="edad" class="form-control" value="<?php echo $edad ?>"><br>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">CELULAR</label>
                            <input type="text" name="celular" class="form-control" value="<?php echo $celular ?>"><br>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">CORREO</label>
                            <input type="text" name="correo" class="form-control" value="<?php echo $correo ?>"><br>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">FECHA DE INGRESO</label>
                            <input type="date" name="fecha_ingreso" class="form-control"
                                value="<?php echo $fecha_ingreso ?>"><br>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">DIRECCIÓN</label>
                            <input type="text" name="direccion" class="form-control"
                                value="<?php echo $direccion ?>"><br>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">CIUDAD DE RESIDENCIA</label>
                            <input type="text" name="ciudad_residencia" class="form-control"
                                value="<?php echo $ciudad_residencia ?>"><br>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">CARGO</label>
                            <input type="text" name="cargo" class="form-control" value="<?php echo $cargo ?>"><br>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">ÁREA</label>
                            <select name="area" class="form-control" required>
                                <?php
                                include("php/conexion.php");

                                $consulta = "SELECT valor FROM parametros WHERE tipo = 'Area'";
                                $resultado = mysqli_query($conexion, $consulta);

                                while ($fila = mysqli_fetch_assoc($resultado)) {
                                    echo '<option value="' . $fila['valor'] . '">' . $fila['valor'] . '</option>';
                                }
                                ?>
                            </select><br>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">TIPO DE CONTRATO</label>
                            <input type="text" name="tipo_contrato" class="form-control"
                                value="<?php echo $tipo_contrato ?>"><br>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">LÍDER INMEDIATO</label>
                            <input type="text" name="lider_inmediato" class="form-control"
                                value="<?php echo $lider_inmediato ?>"><br>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">CAJA DE COMPENSACIÓN</label>
                            <select name="caja" class="form-control" required>
                                <?php
                                include("php/conexion.php");

                                $consulta = "SELECT valor FROM parametros WHERE tipo = 'Caja'";
                                $resultado = mysqli_query($conexion, $consulta);

                                while ($fila = mysqli_fetch_assoc($resultado)) {
                                    echo '<option value="' . $fila['valor'] . '">' . $fila['valor'] . '</option>';
                                }
                                ?>
                            </select><br>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">EPS</label>
                            <select name="eps" class="form-control" required>
                                <?php
                                include("php/conexion.php");

                                $consulta = "SELECT valor FROM parametros WHERE tipo = 'EPS'";
                                $resultado = mysqli_query($conexion, $consulta);

                                while ($fila = mysqli_fetch_assoc($resultado)) {
                                    echo '<option value="' . $fila['valor'] . '">' . $fila['valor'] . '</option>';
                                }
                                ?>
                            </select><br>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">ARL</label>
                            <select name="arl" class="form-control" required>
                                <?php
                                include("php/conexion.php");

                                $consulta = "SELECT valor FROM parametros WHERE tipo = 'ARL'";
                                $resultado = mysqli_query($conexion, $consulta);

                                while ($fila = mysqli_fetch_assoc($resultado)) {
                                    echo '<option value="' . $fila['valor'] . '">' . $fila['valor'] . '</option>';
                                }
                                ?>
                            </select><br>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">PENSIONES</label>
                            <select name="pensiones" class="form-control" required>
                                <?php
                                include("php/conexion.php");

                                $consulta = "SELECT valor FROM parametros WHERE tipo = 'Pensiones'";
                                $resultado = mysqli_query($conexion, $consulta);

                                while ($fila = mysqli_fetch_assoc($resultado)) {
                                    echo '<option value="' . $fila['valor'] . '">' . $fila['valor'] . '</option>';
                                }
                                ?>
                            </select><br>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">CESANTÍAS</label>
                            <select name="cesantias" class="form-control" required>
                                <?php
                                include("php/conexion.php");

                                $consulta = "SELECT valor FROM parametros WHERE tipo = 'Cesantias'";
                                $resultado = mysqli_query($conexion, $consulta);

                                while ($fila = mysqli_fetch_assoc($resultado)) {
                                    echo '<option value="' . $fila['valor'] . '">' . $fila['valor'] . '</option>';
                                }
                                ?>
                            </select><br>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">IMAGEN</label>
                            <input type="text" name="imagen" class="form-control" value="<?php echo $imagen ?>"><br>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">ESTADO</label>
                            <input type="text" name="estado" class="form-control" value="<?php echo $estado ?>"
                                disabled><br>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">FECHA DE RETIRO</label>
                            <input type="text" name="fecha_retiro" class="form-control"
                                value="<?php echo $fecha_retiro ?>" disabled><br>
                        </div>

                        <input type="hidden" name="cedula" value="<?php echo $cedula ?>">

                    </div>
                    <div class="text-center mt-4">
                        <button type="submit" name="enviar" id="btn-enviar" class="btn btn-success btn-lg me-2">
                            <i class="fas fa-check-circle"></i> Editar
                        </button>
                        <a href="index_integrante.php" class="btn btn-danger btn-lg">
                            <i class="fas fa-arrow-left"></i> Regresar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>