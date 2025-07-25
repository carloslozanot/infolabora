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

$cedula = $_SESSION['usuario'];
include("php/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle Vacaciones</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="docs/css/estilos.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
</head>

<body>

    <?php
    $stmt = $conexion->prepare("CALL infolabora.pr_inicial(?)");
    $stmt->bind_param("s", $cedula);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($fila = $resultado->fetch_assoc()) {
        $total_dias_totales = $fila['total_dias_totales'] ?? 0;
        $total_dias_disfrutados = $fila['total_dias_disfrutados'] ?? 0;
        $total_dias_dinero = $fila['total_dias_dinero'] ?? 0;
        $dias_generados = $fila['dias_generados'] ?? 0;

        $_SESSION['total_dias_generados'] = $dias_generados + $total_dias_totales;
        $_SESSION['total_dias'] = $_SESSION['total_dias_generados'] - ($total_dias_disfrutados + $total_dias_dinero);
    } else {
        $_SESSION['total_dias_generados'] = 0;
        $_SESSION['total_dias'] = 0;
        $total_dias_totales = $total_dias_disfrutados = $total_dias_dinero = 0;
    }
    $stmt->close();

    $sql = "SELECT * FROM vacaciones WHERE cedula = '$cedula'";
    $resultado2 = mysqli_query($conexion, $sql);
    ?>

    <div id="contenido-det-vacaciones">
        <div class="container mt-4">
            <div class="row">
                <div class="card shadow-lg p-4 seccion-det-vacaciones">
                    <div class="carda shadow-lg border-0 text-center">
                        <div class="carda-body">
                            <i class="bi bi-plus-circle-fill icono-carda mb-2" style="font-size: 2rem;"></i>
                            <h5 class="carda-title">Días Totales</h5>
                            <h3 class="mb-0 cantidad-carda"><?php echo $_SESSION['total_dias_generados']; ?></h3>
                        </div>
                    </div>

                    <div class="carda shadow-lg border-0 text-center">
                        <div class="carda-body">
                            <i class="bi bi-calendar-check-fill icono-carda mb-2" style="font-size: 2rem;"></i>
                            <h5 class="carda-title">Días Disfrutados</h5>
                            <h3 class="mb-0 cantidad-carda"><?php echo $total_dias_disfrutados; ?></h3>
                        </div>
                    </div>

                    <div class="carda shadow-lg border-0 text-center">
                        <div class="carda-body">
                            <i class="bi bi-cash-coin icono-carda mb-2" style="font-size: 2rem;"></i>
                            <h5 class="carda-title">Días Pagados</h5>
                            <h3 class="mb-0 cantidad-carda"><?php echo $total_dias_dinero; ?></h3>
                        </div>
                    </div>

                    <div class="carde shadow-lg border-0 text-center">
                        <div class="carda-body">
                            <i class="bi bi-hourglass-split icono-carde mb-2" style="font-size: 2rem;"></i>
                            <h5 class="carde-title">Días Disponibles</h5>
                            <h3 class="mb-0 cantidad-carde"><?php echo $_SESSION['total_dias']; ?></h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="carde shadow-lg border-0 text-center">
                        <div class="carde-body">
                            <i class="bi bi-calendar-event-fill icono-carde mb-2" style="font-size: 2rem;"></i>
                            <h5 class="carde-title mb-3">Detalle de vacaciones por periodo</h5>

                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped tabla-vacaciones">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>Periodo</th>
                                            <th>Días Totales</th>
                                            <th>Días Disfrutados</th>
                                            <th>Días Remunerados</th>
                                            <th>Días Faltantes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $contador = 1;
                                        mysqli_data_seek($resultado2, 0);
                                        while ($fila2 = mysqli_fetch_assoc($resultado2)) {
                                            $total_faltantes = ($fila2["dias_disfrutados"] + $fila2["dias_dinero"]) - $fila2["dias_totales"];
                                            echo "<tr>";
                                            echo "<td>{$contador}</td>";
                                            echo "<td>{$fila2['periodo']}</td>";
                                            echo "<td>{$fila2['dias_totales']}</td>";
                                            echo "<td>{$fila2['dias_disfrutados']}</td>";
                                            echo "<td>{$fila2['dias_dinero']}</td>";
                                            echo "<td>{$total_faltantes}</td>";
                                            echo "</tr>";
                                            $contador++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container my-4">
            <div class="botones-vacaciones d-flex justify-content-center">
                <a href="index_integrante.php" class="btn btn-danger">Regresar</a>
            </div>
        </div>
    </div>

</body>

</html>