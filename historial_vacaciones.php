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

$cedula = $_SESSION['usuario'];

$sql = "SELECT * FROM solicitudes WHERE cedula = '$cedula' ORDER BY fecha_diligenciamiento DESC";
$resultado = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Historial de Solicitudes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://kit.fontawesome.com/41bcea2ae3.css" crossorigin="anonymous">
    <style>
        .card {
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .table thead {
            background-color: #150940;
            color: white;
        }

        .btn-warning {
            font-size: 14px;
            padding: 4px 12px;
            border-radius: 6px;
        }

        .table {
            font-size: 16px;
        }
    </style>
</head>

<body class="p-4">
    <div id="agregar-solicitud">
        <div class="container">
            <div class="card">
                <div class="card-header text-white" style="background-color: #150940">
                    <h3 class="mb-0"><i class="fas fa-history"></i> HISTORIAL DE SOLICITUDES</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-middle text-center">
                            <thead>
                                <tr>
                                    <th>Radicado</th>
                                    <th>Fecha Diligenciamiento</th>
                                    <th>Periodo</th>
                                    <th>Fecha de inicio</th>
                                    <th>Fecha de reintegro</th>
                                    <th>Días</th>
                                    <th>Dinero</th>
                                    <th>Estado</th>
                                    <th>Comentario</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($fila = mysqli_fetch_assoc($resultado)) {
                                    echo "<tr>
                                        <td>{$fila['radicado']}</td>
                                        <td>{$fila['fecha_diligenciamiento']}</td>
                                        <td>{$fila['periodo']}</td>
                                        <td>{$fila['fecha_inicio']}</td>
                                        <td>{$fila['fecha_reintegro']}</td>
                                        <td>{$fila['dias']}</td>
                                        <td>{$fila['dinero']}</td>
                                        <td>";
                                    $estado = $fila['estado'];
                                    if ($estado === 'Solicitadas') {
                                        echo "<span class='badge bg-secondary'>{$estado}</span>";
                                    } elseif ($estado === 'Aprobadas') {
                                        echo "<span class='badge bg-success'>{$estado}</span>";
                                    } elseif ($estado === 'Rechazadas') {
                                        echo "<span class='badge bg-danger'>{$estado}</span>";
                                    } else {
                                        echo "<span class='badge bg-light text-dark'>{$estado}</span>";
                                    }

                                    echo "</td>
                                        <td>{$fila['comentarios']}</td>
                                        <td>" .
                                        ($fila['estado'] === 'Solicitadas'
                                            ? "<a href='editar_solicitud.php?id={$fila['radicado']}' class='btn btn-warning btn-md'><i class='fas fa-edit'></i> Editar</a>"
                                            : "—") .
                                        "</td>
                                    </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-3">
                        <a href="index_integrante.php" class="btn btn-danger btn-lg">Regresar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>