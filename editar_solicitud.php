<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    echo '<script>alert("Debe iniciar sesión"); window.location = "index.php";</script>';
    exit;
}

include("php/conexion.php");

$cedula = $_SESSION['usuario'];
$radicado = $_GET['id'] ?? '';

// Obtener la solicitud
$sql = "SELECT * FROM solicitudes WHERE radicado = '$radicado' AND cedula = '$cedula'";
$resultado = mysqli_query($conexion, $sql);
$solicitud = mysqli_fetch_assoc($resultado);

// Obtener los días faltantes desde la tabla vacaciones usando el periodo
$dias_faltantes = 0;
if (!empty($solicitud['periodo'])) {
    $periodo = $solicitud['periodo'];
    $sql_vac = "SELECT dias_totales, dias_disfrutados, dias_dinero 
                FROM vacaciones 
                WHERE cedula = '$cedula' AND periodo = '$periodo'";
    $res_vac = mysqli_query($conexion, $sql_vac);
    if ($row = mysqli_fetch_assoc($res_vac)) {
        $dias_faltantes = $row['dias_totales'] - $row['dias_disfrutados'] - $row['dias_dinero'];
    }
}

if ($dias_faltantes <= 0) {
    $dias_faltantes = $_SESSION['dias_generados'] ?? 0;
}

// Actualizar solicitud
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar'])) {
    $fecha_inicio = $_POST['fecha_inicio'] ?? null;
    $fecha_reintegro = $_POST['fecha_reintegro'] ?? null;
    $dias = $_POST['disfrutar'] ?? 0;
    $dinero = $_POST['remunerado'] ?? 0;

    $sql_update = "UPDATE solicitudes SET 
        fecha_inicio = '$fecha_inicio', 
        fecha_reintegro = '$fecha_reintegro', 
        dias = '$dias', 
        dinero = '$dinero'
        WHERE radicado = '$radicado' AND cedula = '$cedula'";

    if (mysqli_query($conexion, $sql_update)) {
        echo "<script>
            alert('✅ Solicitud actualizada con éxito.');
            window.location.href='index_integrante.php';
        </script>";
        exit;
    }
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Solicitud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://kit.fontawesome.com/41bcea2ae3.css" crossorigin="anonymous">
    <style>
        .card {
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="p-4">
    <div class="container">
        <div class="card">
            <div class="card-header text-white" style="background-color: #150940">
                <h3 class="mb-0"><i class="fas fa-edit"></i> EDITAR SOLICITUD</h3>
            </div>
            <div class="card-body">
                <form method="post">
                    <input type="hidden" id="dias_faltantes" value="<?= $dias_faltantes ?>">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>PERIODO</label>
                            <input type="text" name="periodo" class="form-control" value="<?= $solicitud['periodo'] ?>"
                                readonly>
                        </div>
                        <div class="col-md-6">
                            <label>DÍAS PARA TOMAR</label>
                            <input type="number" class="form-control" value="<?= $dias_faltantes ?>" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>Fecha Inicio del periodo vacacional</label>
                            <input type="date" name="fecha_inicio" class="form-control"
                                value="<?= $solicitud['fecha_inicio'] ?>">
                        </div>
                        <div class="col-md-6">
                            <label>Fecha de reintegro a la organización</label>
                            <input type="date" name="fecha_reintegro" class="form-control"
                                value="<?= $solicitud['fecha_reintegro'] ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>Disfrutar en Días</label>
                            <input type="number" name="disfrutar" id="disfrutar" class="form-control"
                                value="<?= $solicitud['dias'] ?>">
                        </div>
                        <div class="col-md-6">
                            <label>Remunerado en Dinero</label>
                            <input type="number" name="remunerado" id="remunerado" class="form-control"
                                value="<?= $solicitud['dinero'] ?>">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-success" id="btn-enviar"
                            name="actualizar">Actualizar</button>
                        <a href="index_integrante.php" class="btn btn-danger">Regresar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const btn = document.getElementById("btn-enviar");
            const inputDisfrutar = document.getElementById("disfrutar");
            const inputRemunerado = document.getElementById("remunerado");
            const inputInicio = document.querySelector('input[name="fecha_inicio"]');
            const inputReintegro = document.querySelector('input[name="fecha_reintegro"]');
            const diasFaltantes = parseFloat(document.getElementById("dias_faltantes").value) || 0;

            function validarTotal() {
                const disfrutar = parseFloat(inputDisfrutar.value) || 0;
                const dinero = parseFloat(inputRemunerado.value) || 0;
                const total = disfrutar + dinero;

                if (total > diasFaltantes) {
                    alert("⚠️ La suma de los días no puede superar los días disponibles: " + diasFaltantes);
                    btn.disabled = true;
                } else {
                    btn.disabled = false;
                }
            }

            function calcularDiasHabiles(fechaInicio, fechaReintegro, festivos = []) {
                let contador = 0;
                const fInicio = new Date(fechaInicio);
                const fReintegro = new Date(fechaReintegro);
                fReintegro.setDate(fReintegro.getDate() - 1); // No cuenta el día de reintegro

                while (fInicio <= fReintegro) {
                    const dia = fInicio.getDay(); // 0 = domingo, 6 = sábado
                    const yyyyMMdd = fInicio.toISOString().split("T")[0];

                    if (dia !== 0 && dia !== 6 && !festivos.includes(yyyyMMdd)) {
                        contador++;
                    }

                    fInicio.setDate(fInicio.getDate() + 1);
                }

                return contador;
            }

            function calcularDias() {
                const fechaInicio = new Date(inputInicio.value);
                const fechaReintegro = new Date(inputReintegro.value);
                const festivos = ["2025-01-01", "2025-03-24", "2025-05-01", "2025-06-09", "2025-07-20", "2025-08-07", "2025-12-08", "2025-12-25"]; // personaliza

                if (!isNaN(fechaInicio) && !isNaN(fechaReintegro)) {
                    if (fechaInicio >= fechaReintegro) {
                        alert("⚠️ La fecha de inicio debe ser menor que la fecha de reintegro.");
                        inputReintegro.value = '';
                        inputDisfrutar.value = '';
                        btn.disabled = true;
                        return;
                    }

                    const diffHabiles = calcularDiasHabiles(inputInicio.value, inputReintegro.value, festivos);

                    if (diffHabiles > diasFaltantes) {
                        alert("⚠️ La diferencia entre fechas no puede superar los días disponibles (" + diasFaltantes + ").");
                        inputReintegro.value = '';
                        inputDisfrutar.value = '';
                        btn.disabled = true;
                    } else {
                        inputDisfrutar.value = diffHabiles >= 0 ? diffHabiles : 0;
                        validarTotal();
                    }
                }
            }

            inputDisfrutar.addEventListener("input", validarTotal);
            inputRemunerado.addEventListener("input", validarTotal);
            inputInicio.addEventListener("change", calcularDias);
            inputReintegro.addEventListener("change", calcularDias);

            calcularDias(); // Llama al cargar por si ya hay valores
        });
    </script>

</body>

</html>