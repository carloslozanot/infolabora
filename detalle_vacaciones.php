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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="docs/css/estilos.css">
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
</head>

<body>

    <div id="contenido-det-vacaciones" class="contenido" style="display: none;">
        <h2 style="text-align: center;font-size: 40px; font-weight: 800;">DETALLE DE VACACIONES</h2><br>

        <?php
        include("php/conexion.php");
        $sql = "SELECT * FROM vacaciones WHERE cedula = '$cedula'";
        $resultado = mysqli_query($conexion, $sql);
        $fila = mysqli_fetch_assoc($resultado);
        ?>

        <div class="row justify-content-center">
            <div class="col-md-5 mb-4">
                <div class="card card-hover shadow-lg border-0 text-center">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                        <div class="mb-2">
                            <i class="bi bi-person-check-fill icono-card"></i>
                        </div>
                        <h5 class="card-title mb-1">Ingresos al sistema</h5>
                        <h3 class="mb-0 cantidad-card"></h3>
                    </div>
                </div>
            </div>

            <div class="col-md-10 mb-4">
                <div class="card card-hover shadow-lg border-0 text-center">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="bi bi-people-fill icono-card"></i>
                        </div>
                        <h5 class="card-title mb-3">Top ingresos al sistema</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre Completo</th>
                                        <th>Total Ingresos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!--<?php
                                    $contador = 1;
                                    mysqli_data_seek($resultado_integrantes, 0);
                                    while ($fila = mysqli_fetch_assoc($resultado_integrantes)) {
                                        echo "<tr>";
                                        echo "<td>{$contador}</td>";
                                        echo "<td>{$fila['nombre_completo']}</td>";
                                        echo "<td>{$fila['total_ingreso']}</td>";
                                        echo "</tr>";
                                        $contador++;
                                    }
                                    ?>-->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>