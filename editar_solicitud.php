<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    echo '<script>alert("Debe iniciar sesión"); window.location = "index.php";</script>';
    exit;
}

include("php/conexion.php");

$cedula = $_SESSION['usuario'];
$radicado = $_GET['id'] ?? '';

$sql = "SELECT * FROM solicitudes WHERE radicado = '$radicado' AND cedula = '$cedula'";
$resultado = mysqli_query($conexion, $sql);
$solicitud = mysqli_fetch_assoc($resultado);

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
            function validarTotal() {
                const diasDisfrutar = parseFloat(document.getElementById("disfrutar").value) || 0;
                const remunerado = parseFloat(document.getElementById("remunerado").value) || 0;
                const diasFaltantes = <?= (int) $_SESSION['dias_generados'] ?>;
                const total = diasDisfrutar + remunerado;

                if (total > diasFaltantes) {
                    alert("La suma de los días no puede superar los días faltantes: " + diasFaltantes);
                    document.getElementById("btn-enviar").disabled = true;
                } else {
                    document.getElementById("btn-enviar").disabled = false;
                }
            }

            document.getElementById("disfrutar").addEventListener("input", validarTotal);
            document.getElementById("remunerado").addEventListener("input", validarTotal);
        });
    </script>
</body>

</html>