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
            window.location.href='historial_solicitudes.php';
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
        .form-control[disabled], .form-select[disabled] {
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
                        <input type="text" class="form-control" value="<?= $solicitud['fecha_diligenciamiento'] ?>" disabled>
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

                <?php if ($solicitud['estado'] === 'Solicitadas') : ?>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>Fecha Inicio</label>
                            <input type="date" name="fecha_inicio" class="form-control" value="<?= $solicitud['fecha_inicio'] ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label>Fecha Reintegro</label>
                            <input type="date" name="fecha_reintegro" class="form-control" value="<?= $solicitud['fecha_reintegro'] ?>" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>Días a disfrutar</label>
                            <input type="number" name="disfrutar" class="form-control" value="<?= $solicitud['dias'] ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label>Remunerado en dinero</label>
                            <input type="number" name="remunerado" class="form-control" value="<?= $solicitud['dinero'] ?>" required>
                        </div>
                    </div>

                    <button type="submit" name="actualizar" class="btn btn-primary">Actualizar</button>
                <?php else : ?>
                    <div class="alert alert-warning">Solo se pueden editar solicitudes en estado <strong>Solicitadas</strong>.</div>
                <?php endif; ?>

                <a href="historial_solicitudes.php" class="btn btn-secondary ms-2">Volver</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>
