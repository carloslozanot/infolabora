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

include("php/conexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enviar'])) {
    $fecha_diligenciamiento = date('Y-m-d');
    $fecha_ingreso = $_SESSION['fecha_ingreso'] ?? null;
    $cedula = $_SESSION['usuario'];
    $nombre_completo = ($_SESSION['nombreUsuario'] ?? '') . ' ' . ($_SESSION['apellidoUsuario'] ?? '');
    $cargo = $_SESSION['cargo'] ?? null;
    $area = $_SESSION['area'] ?? null;
    $periodo = $_POST['periodo'] ?? null;
    $fecha_inicio = $_POST['fecha_inicio'] ?? null;
    $fecha_reintegro = $_POST['fecha_reintegro'] ?? null;
    $dias = $_POST['disfrutar'] ?? 0;
    $dinero = $_POST['remunerado'] ?? 0;

    // Validar que todos los campos obligatorios tengan valores
    if ($periodo && $fecha_inicio && $fecha_reintegro && $dias !== '' && $dinero !== '') {
        $sql_insert = "INSERT INTO solicitudes (
            fecha_diligenciamiento, fecha_ingreso, cedula, nombre_completo, cargo, area, periodo, fecha_inicio, fecha_reintegro, dias, dinero, estado, radicado, comentarios
        ) VALUES (
            '$fecha_diligenciamiento', '$fecha_ingreso', '$cedula', '$nombre_completo', '$cargo', '$area', '$periodo', '$fecha_inicio', '$fecha_reintegro', '$dias', '$dinero', 'Solicitadas', NULL, NULL
        )";


        if (mysqli_query($conexion, $sql_insert)) {
            $id_generado = mysqli_insert_id($conexion);
            $radicado = "VAC-" . date('Y') . "-" . str_pad($id_generado, 5, "0", STR_PAD_LEFT);

            // Actualiza el registro recién insertado con el radicado generado
            $sql_update_radicado = "UPDATE solicitudes SET radicado = '$radicado' WHERE id_solicitud = $id_generado";
            mysqli_query($conexion, $sql_update_radicado);

            echo "<script>
        alert('✅ Solicitud registrada con éxito.\\nNúmero de radicado: $radicado');
        window.location.href='index_integrante.php';
    </script>";
            exit;
        }
    }
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
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="docs/css/estilos.css">
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

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



<body class="bg-light">
    <div id="agregar-solicitud">
        <?php
        include("php/conexion.php");

        $cedula = $_SESSION['usuario'];
        $nombres = $_SESSION['nombreUsuario'] ?? '';
        $apellidos = $_SESSION['apellidoUsuario'] ?? '';
        $cargo = $_SESSION['cargo'] ?? '';
        $area = $_SESSION['area'] ?? '';
        $fecha_ingreso = $_SESSION['fecha_ingreso'] ?? '';
        $dias_generados = $_SESSION['dias_generados'] ?? '';

        $sql_periodos = "SELECT DISTINCT periodo FROM vacaciones WHERE cedula = '$cedula' ORDER BY periodo DESC";
        $resultado_periodos = mysqli_query($conexion, $sql_periodos);
        ?>
        <div class="card shadow">
            <div class="card-header titulo-solicitud text-white">
                <h3 class="mb-0"><i class="fas fa-plane-departure"></i> Solicitud de Vacaciones</h3>
            </div>

            <div class="card-body">
                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Fecha de Diligenciamiento</label>
                            <input type="text" class="form-control" value="<?= date('Y-m-d') ?>" disabled>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Fecha Inicio Contrato</label>
                            <input type="text" class="form-control" value="<?= $fecha_ingreso ?>" disabled>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Número de Documento</label>
                            <input type="text" class="form-control" value="<?= $cedula ?>" disabled>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nombre del Trabajador</label>
                            <input type="text" class="form-control" value="<?= $nombres . ' ' . $apellidos ?>" disabled>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Cargo</label>
                            <input type="text" class="form-control" value="<?= $cargo ?>" disabled>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Área</label>
                            <input type="text" class="form-control" value="<?= $area ?>" disabled>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Periodo</label>
                            <select name="periodo" id="periodo" class="form-select" required>
                                <option value="">Seleccione un periodo</option>
                                <?php while ($row = mysqli_fetch_assoc($resultado_periodos)) {
                                    echo '<option value="' . $row['periodo'] . '">' . $row['periodo'] . '</option>';
                                } ?>
                            </select>
                            <div class="mb-3">
                                <label class="form-label">Días Faltantes</label>
                                <input type="text" id="dias_faltantes" class="form-control" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Fecha Inicio del Periodo Vacacional</label>
                            <input type="date" name="fecha_inicio" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Fecha de Reintegro</label>
                            <input type="date" name="fecha_reintegro" class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Días a Disfrutar</label>
                            <input type="number" name="disfrutar" id="disfrutar" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Remunerado en Dinero</label>
                            <input type="number" name="remunerado" id="remunerado" class="form-control">
                        </div>
                    </div>

                    <script>
                        $(document).ready(function () {
                            let campoActivo = '';

                            function toggleCampos(dias_faltantes) {
                                const disable = parseFloat(dias_faltantes) === 0;

                                $('#remunerado').prop('disabled', disable);
                                $('#disfrutar').prop('disabled', disable);
                                $('input[name="fecha_inicio"]').prop('disabled', disable);
                                $('input[name="fecha_reintegro"]').prop('disabled', disable);

                                if (disable) {
                                    $('#remunerado').val('');
                                    $('#disfrutar').val('');
                                }
                            }

                            function calcularDias() {
                                const fechaInicio = new Date($('input[name="fecha_inicio"]').val());
                                const fechaReintegro = new Date($('input[name="fecha_reintegro"]').val());

                                let diffDays = 0;

                                if (!isNaN(fechaInicio) && !isNaN(fechaReintegro)) {
                                    const diffTime = fechaReintegro - fechaInicio;
                                    diffDays = Math.round(diffTime / (1000 * 60 * 60 * 24));
                                    $('#disfrutar').val(diffDays >= 0 ? diffDays : 0);
                                } else {
                                    $('#disfrutar').val('');
                                }

                                validarTotal(diffDays);
                            }

                            function validarTotal(diasDisfrutar) {
                                const remunerado = parseFloat($('#remunerado').val()) || 0;
                                const diasFaltantes = parseFloat($('#dias_faltantes').val()) || 0;
                                const total = diasDisfrutar + remunerado;

                                if (total > diasFaltantes) {
                                    alert("La suma de los días a disfrutar y los días remunerados no puede superar los días faltantes (" + diasFaltantes + ").");

                                    if (campoActivo === 'remunerado') {
                                        $('#remunerado').val('');
                                    } else if (campoActivo === 'disfrutar') {
                                        $('#disfrutar').val('');
                                    }

                                    $('#btn-enviar').prop('disabled', true);
                                } else {
                                    $('#btn-enviar').prop('disabled', false);
                                }
                            }

                            $('#periodo').change(function () {
                                const periodo = $(this).val();
                                const cedula = '<?= $_SESSION['usuario'] ?>';

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
                                            toggleCampos(data.dias_faltantes);
                                        },
                                        error: function () {
                                            $('#dias_totales, #dias_disfrutados, #dias_dinero, #dias_faltantes').val('Error');
                                        }
                                    });
                                } else {
                                    $('#dias_totales, #dias_disfrutados, #dias_dinero, #dias_faltantes').val('');
                                }
                            });

                            $('input[name="fecha_inicio"], input[name="fecha_reintegro"]').on('change', calcularDias);

                            $('#remunerado').on('input', function () {
                                campoActivo = 'remunerado';
                                const diasDisfrutar = parseFloat($('#disfrutar').val()) || 0;
                                validarTotal(diasDisfrutar);
                            });

                            $('#disfrutar').on('input', function () {
                                campoActivo = 'disfrutar';
                                const diasDisfrutar = parseFloat($(this).val()) || 0;
                                validarTotal(diasDisfrutar);
                            });

                            // ✅ Validación final antes de enviar
                            $('#btn-enviar').on('click', function (e) {
                                const periodo = $('#periodo').val();
                                const fechaInicio = $('input[name="fecha_inicio"]').val();
                                const fechaReintegro = $('input[name="fecha_reintegro"]').val();
                                const disfrutar = $('#disfrutar').val().trim();
                                const remunerado = $('#remunerado').val().trim();

                                if (periodo === '') {
                                    alert("Debe seleccionar un periodo.");
                                    $('#periodo').focus();
                                    e.preventDefault();
                                    return;
                                }

                                if (fechaInicio === '') {
                                    alert("Debe ingresar la fecha de inicio de vacaciones.");
                                    $('input[name="fecha_inicio"]').focus();
                                    e.preventDefault();
                                    return;
                                }

                                if (fechaReintegro === '') {
                                    alert("Debe ingresar la fecha de reintegro.");
                                    $('input[name="fecha_reintegro"]').focus();
                                    e.preventDefault();
                                    return;
                                }

                                if (disfrutar === '') {
                                    alert("Debe indicar los días a disfrutar.");
                                    $('#disfrutar').focus();
                                    e.preventDefault();
                                    return;
                                }

                                if (remunerado === '') {
                                    alert("El campo 'Remunerado en Dinero' es obligatorio.");
                                    $('#remunerado').focus();
                                    e.preventDefault();
                                    return;
                                }
                            });
                        });
                    </script>

                    <div class="text-center mt-4">
                        <button type="submit" name="enviar" id="btn-enviar" class="btn btn-success me-2">
                            <i class="fas fa-check-circle"></i> Solicitar
                        </button>
                        <a href="index_integrante.php" class="btn btn-danger">
                            <i class="fas fa-arrow-left"></i> Regresar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>