<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    echo '
            <script>
                alert("Debe iniciar sesión");
                window.location = "index.php";
            </script>
        ';
    exit;

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud Vacaciones</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="docs/css/estilos.css">
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
</head>

<script>
    $(document).ready(function () {
        $('select[name="periodo"]').change(function () {
            var periodo = $(this).val();
            var cedula = '<?php echo $cedula; ?>';

            if (periodo !== '') {
                $.ajax({
                    url: 'get_dias_totales.php',
                    type: 'POST',
                    data: { periodo: periodo, cedula: cedula },
                    success: function (data) {
                        $('#dias_totales').val(data); 
                        $('#dias_totales_hidden').val(data); 
                    }
                });
            } else {
                $('#dias_totales').val('');
                $('#dias_totales_hidden').val('');
            }
        });
    });
</script>


<body>
    <div id="agregar-solicitud">
        <?php
        include("php/conexion.php");

        $cedula = $_SESSION['usuario'];
        $nombres = $_SESSION['nombres'] ?? '';
        $apellidos = $_SESSION['apellidos'] ?? '';
        $cargo = $_SESSION['cargo'] ?? '';
        $area = $_SESSION['area'] ?? '';
        $fecha_ingreso = $_SESSION['fecha_ingreso'] ?? '';

        $sql_periodos = "SELECT DISTINCT periodo FROM vacaciones WHERE cedula = '$cedula' ORDER BY periodo DESC";
        $resultado_periodos = mysqli_query($conexion, $sql_periodos);

        if (isset($_POST['enviar'])) {

            /*$cedula = $_POST['cedula'];
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

            $sql = "INSERT INTO solicitudes (
                        id_empleado, cedula, nombres, apellidos, edad, celular, correo,
                        fecha_ingreso, cargo, area, lider_inmediato,
                        caja, eps, arl, pensiones, cesantias, imagen, direccion, ciudad_residencia, tipo_contrato, estado, fecha_retiro
                    ) VALUES (
                        $nuevo_id, '$cedula', '$nombres', '$apellidos', '$edad', '$celular', '$correo',
                        '$fecha_ingreso', '$cargo', '$area', '$lider_inmediato', '$caja', '$eps', '$arl', 
                        '$pensiones', '$cesantias', '$imagen', '$direccion', '$ciudad_residencia', '$tipo_contrato',
                        '$estado', '$fecha_retiro'
                    )";

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
            }*/

            mysqli_close($conexion);
        }
        ?>

        <div class="titulo-agregar-solicitud">
            <h1>Solicitud de vacaciones</h1>
        </div>

        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">

            <h2>Fecha de Diligenciamiento</h2>
            <input type="text" class="form-control" value="<?= date('Y-m-d') ?>" disabled>

            <h2>Fecha Inicio Contrato</h2>
            <input type="text" name="fecha_ingreso" class="form-control" value="<?php echo $fecha_ingreso ?>" disabled>

            <h2>Numero Documento</h2>
            <input type="text" name="cedula" class="form-control" value="<?php echo $cedula ?>" disabled>

            <h2>Nombre del trabajador</h2>
            <input type="text" class="form-control" value="<?php echo $nombres . ' ' . $apellidos ?>" disabled>

            <h2>Cargo</h2>
            <input type="text" name="cargo" class="form-control" value="<?php echo $cargo ?>" disabled>

            <h2>Area</h2>
            <input type="text" name="area" class="form-control" value="<?php echo $area ?>" disabled>

            <h2>Periodo</h2>
            <select name="periodo" class="form-control" required>
                <option value="">Seleccione un periodo</option>
                <?php
                while ($row = mysqli_fetch_assoc($resultado_periodos)) {
                    echo '<option value="' . $row['periodo'] . '">' . $row['periodo'] . '</option>';
                }
                ?>
            </select>

            <h2>Dias totales</h2>
            <input type="text" id="dias_totales" class="form-control" disabled>
            <input type="hidden" name="dias_totales" id="dias_totales_hidden">

            <div class="botones-agregar-solicitud">
                <button type="submit" class="btn btn-success" name="enviar">Agregar</button>
                <a href="index_integrante.php" class="btn btn-danger">Regresar</a>
            </div>
        </form>
    </div>
</body>

</html>