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
<html lang="es">

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
        $('#periodo').change(function () {
            const periodo = $(this).val();
            const cedula = '<?php echo $_SESSION['usuario']; ?>';

            if (periodo !== "") {
                $.ajax({
                    url: 'get_dias_totales.php',
                    type: 'GET',
                    data: { cedula: cedula, periodo: periodo },
                    dataType: 'json',
                    success: function (data) {
                        $('#dias_totales').val(data.dias_totales);
                        $('#dias_disfrutados').val(data.dias_disfrutados);
                        $('#dias_dinero').val(data.dias_dinero);
                        $('#dias_faltantes').val(data.dias_faltantes);
                    },
                    error: function () {
                        $('#dias_totales').val('Error');
                        $('#dias_disfrutados').val('Error');
                        $('#dias_dinero').val('Error');
                        $('#dias_faltantes').val('Error');
                    }
                });
            } else {
                $('#dias_totales').val('');
                $('#dias_disfrutados').val('');
                $('#dias_dinero').val('');
                $('#dias_faltantes').val('');
            }
        });
    });
</script>



<body>
    <div id="agregar-solicitud">
        <?php
        include("php/conexion.php");

        $cedula = $_SESSION['usuario'];
        $nombres = $_SESSION['nombreUsuario'] ?? '';
        $apellidos = $_SESSION['apellidos'] ?? '';
        $cargo = $_SESSION['cargo'] ?? '';
        $area = $_SESSION['area'] ?? '';
        $fecha_ingreso = $_SESSION['fecha_ingreso'] ?? '';
        $dias_generados = $_SESSION['dias_generados'] ?? '';

        $sql_periodos = "SELECT DISTINCT periodo FROM vacaciones WHERE cedula = '$cedula' ORDER BY periodo DESC";
        $resultado_periodos = mysqli_query($conexion, $sql_periodos);
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
            <input type="text" name="cedula_visible" class="form-control" value="<?php echo $cedula ?>" disabled>

            <h2>Nombre del trabajador</h2>
            <input type="text" class="form-control" value="<?php echo $nombres . ' ' . $apellidos ?>" disabled>

            <h2>Cargo</h2>
            <input type="text" name="cargo" class="form-control" value="<?php echo $cargo ?>" disabled>

            <h2>Area</h2>
            <input type="text" name="area" class="form-control" value="<?php echo $area ?>" disabled>

            <h2>Periodo</h2>
            <select name="periodo" id="periodo" class="form-control" required>
                <option value="">Seleccione un periodo</option>
                <?php
                while ($row = mysqli_fetch_assoc($resultado_periodos)) {
                    echo '<option value="' . $row['periodo'] . '">' . $row['periodo'] . '</option>';
                }
                ?>
            </select>

            <!--<h2>Días Totales</h2>
            <input type="text" id="dias_totales" class="form-control" readonly>

            <h2>Días Disfrutados</h2>
            <input type="text" id="dias_disfrutados" class="form-control" readonly>

            <h2>Días en Dinero</h2>
            <input type="text" id="dias_dinero" class="form-control" readonly>-->

            <h2>Días Faltantes</h2>
            <input type="text" id="dias_faltantes" class="form-control" readonly>

            <h2>Fecha Inicio del periodo vacacional</h2>
            <input type="date" name="fecha_inicio" value="<?= date('Y-m-d') ?>" class="form-control">

            <h2>Fecha de reintegro a la organización</h2>
            <input type="date" name="fecha_reintegro" value="<?= date('Y-m-d') ?>" class="form-control">

            <h2>Remunerado en Dinero</h2>
            <input type="text" id="remunerado" class="form-control">

            <h2>Disfrutar en Días</h2>
            <input type="text" id="disfrutar" class="form-control">

            <div class="botones-agregar-solicitud">
                <button type="submit" class="btn btn-success" name="enviar">Agregar</button>
                <a href="index_integrante.php" class="btn btn-danger">Regresar</a>
            </div>
        </form>
    </div>
</body>

</html>