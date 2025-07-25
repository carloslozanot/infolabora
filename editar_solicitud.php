<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    echo '<script>alert("Debe iniciar sesión"); window.location = "index.php";</script>';
    exit;
}

include("php/conexion.php");

$cedula = $_SESSION['usuario'];
$radicado = $_GET['id'] ?? null;

if (!$radicado) {
    echo '<script>alert("Radicado no especificado"); window.location = "historial_solicitudes.php";</script>';
    exit;
}

// Obtener la solicitud
$sql = "SELECT * FROM solicitudes WHERE cedula = '$cedula' AND radicado = '$radicado'";
$resultado = mysqli_query($conexion, $sql);
$solicitud = mysqli_fetch_assoc($resultado);

if (!$solicitud) {
    echo '<script>alert("Solicitud no encontrada"); window.location = "historial_solicitudes.php";</script>';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar'])) {
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_reintegro = $_POST['fecha_reintegro'];
    $dias = $_POST['disfrutar'];
    $dinero = $_POST['remunerado'];

    $sql_update = "UPDATE solicitudes SET 
        fecha_inicio = '$fecha_inicio', 
        fecha_reintegro = '$fecha_reintegro', 
        dias = '$dias', 
        dinero = '$dinero' 
        WHERE radicado = '$radicado' AND estado = 'Solicitadas'";

    if (mysqli_query($conexion, $sql_update)) {
        echo "<script>
            alert('✅ Solicitud actualizada con éxito.');
            window.location.href='index_integrante.php';
        </script>";
        exit;
    } else {
        echo "<script>alert('❌ Error al actualizar la solicitud.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Solicitud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-control[disabled],
        .form-select[disabled] {
            background-color: #f1f1f1;
        }

        .titulo {
            background-color: #150940;
            color: white;
            padding: 15px;
            border-radius: 8px 8px 0 0;
        }
    </style>
</head>

<body class="p-4">
    <div class="container">
        <div class="card shadow">
            <div class="titulo">
                <h3><i class="fas fa-edit"></i> Editar Solicitud</h3>
            </div>
            <div class="card-body">
                <form method="post">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>Radicado</label>
                            <input type="text" class="form-control" value="<?= $solicitud['radicado'] ?>" disabled>
                        </div>
                        <div class="col-md-6">
                            <label>Fecha Diligenciamiento</label>
                            <input type="text" class="form-control" value="<?= $solicitud['fecha_diligenciamiento'] ?>"
                                disabled>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>Periodo</label>
                            <input type="text" class="form-control" value="<?= $solicitud['periodo'] ?>" disabled>
                        </div>
                        <div class="col-md-6">
                            <label>Estado</label>
                            <input type="text" class="form-control" value="<?= $solicitud['estado'] ?>" disabled>
                        </div>
                    </div>

                    <?php if ($solicitud['estado'] === 'Solicitadas'): ?>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Fecha Inicio</label>
                                <input type="date" name="fecha_inicio" class="form-control"
                                    value="<?= $solicitud['fecha_inicio'] ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label>Fecha Reintegro</label>
                                <input type="date" name="fecha_reintegro" class="form-control"
                                    value="<?= $solicitud['fecha_reintegro'] ?>" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Días a disfrutar</label>
                                <input type="number" name="disfrutar" class="form-control" value="<?= $solicitud['dias'] ?>"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label>Remunerado en dinero</label>
                                <input type="number" name="remunerado" class="form-control"
                                    value="<?= $solicitud['dinero'] ?>" required>
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

                        <button type="submit" name="actualizar" class="btn btn-primary">Actualizar</button>
                    <?php else: ?>
                        <div class="alert alert-warning">Solo se pueden editar solicitudes en estado
                            <strong>Solicitadas</strong>.</div>
                    <?php endif; ?>

                    <a href="index_integrante.php" class="btn btn-secondary ms-2">Volver</a>
                </form>
            </div>
        </div>
    </div>
</body>

</html>