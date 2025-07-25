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
    <title>Solicitud Vacaciones</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;900&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
                success: function (data) {
                    $('#dias_totales').val(data);
                },
                error: function () {
                    $('#dias_totales').val('Error');
                }
            });
        } else {
            $('#dias_totales').val('');
        }
    });
});
</script>

<body>
<div class="container mt-5" id="agregar-solicitud">
    <?php
    include("php/conexion.php");

    $cedula = $_SESSION['usuario'];
    $nombres = $_SESSION['nombreUsuario'] ?? '';
    $apellidos = $_SESSION['apellidos'] ?? '';
    $cargo = $_SESSION['cargo'] ?? '';
    $area = $_SESSION['area'] ?? '';
    $fecha_ingreso = $_SESSION['fecha_ingreso'] ?? '';

    $sql_periodos = "SELECT DISTINCT periodo FROM vacaciones WHERE cedula = '$cedula' ORDER BY periodo DESC";
    $resultado_periodos = mysqli_query($conexion, $sql_periodos);
    ?>

    <div class="titulo-agregar-solicitud mb-4">
        <h1>Solicitud de vacaciones</h1>
    </div>

    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
        <div class="mb-3">
            <label>Fecha de Diligenciamiento</label>
            <input type="text" class="form-control" value="<?= date('Y-m-d') ?>" disabled>
        </div>

        <div class="mb-3">
            <label>Fecha Inicio Contrato</label>
            <input type="text" name="fecha_ingreso" class="form-control" value="<?php echo $fecha_ingreso ?>" disabled>
        </div>

        <div class="mb-3">
            <label>Número Documento</label>
            <input type="text" class="form-control" value="<?php echo $cedula ?>" disabled>
            <input type="hidden" name="cedula" value="<?php echo $cedula ?>">
        </div>

        <div class="mb-3">
            <label>Nombre del trabajador</label>
            <input type="text" class="form-control" value="<?php echo $nombres . ' ' . $apellidos ?>" disabled>
        </div>

        <div class="mb-3">
            <label>Cargo</label>
            <input type="text" class="form-control" value="<?php echo $cargo ?>" disabled>
        </div>

        <div class="mb-3">
            <label>Área</label>
            <input type="text" class="form-control" value="<?php echo $area ?>" disabled>
        </div>

        <div class="mb-3">
            <label>Período</label>
            <select name="periodo" id="periodo" class="form-control" required>
                <option value="">Seleccione un período</option>
                <?php
                while ($row = mysqli_fetch_assoc($resultado_periodos)) {
                    echo '<option value="' . $row['periodo'] . '">' . $row['periodo'] . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Días totales</label>
            <input type="text" id="dias_totales" class="form-control" readonly>
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-success" name="enviar">Agregar</button>
            <a href="index_integrante.php" class="btn btn-danger">Regresar</a>
        </div>
    </form>
</div>
</body>
</html>
