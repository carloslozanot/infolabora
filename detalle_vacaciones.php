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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="docs/css/estilos.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
</head>

<body>

    <div id="contenido-det-vacaciones">
        <h2 style="text-align: center;font-size: 40px; font-weight: 800;">DETALLE DE VACACIONES</h2><br>

        <?php
        $stmt = $conexion->prepare("CALL infolabora.pr_inicial(?)");
        $stmt->bind_param("s", $cedula);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($fila = $resultado->fetch_assoc()) {
            $total_dias_totales = $fila['total_dias_totales'];
            $total_dias_disfrutados = $fila['total_dias_disfrutados'];
            $total_dias_dinero = $fila['total_dias_dinero'];
        } else {
            $total_dias_totales = "0";
            $total_dias_disfrutados = "0";
            $total_dias_dinero = "0";
        }

        $stmt->close();
        ?>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-4 mb-4">
                    <div class="card card-hover shadow-lg border-0 text-center">
                        <div class="card-body d-flex flex-column align-items-center justify-content-center">
                            <div class="mb-2">
                                <i class="bi bi-file-earmark-check-fill icono-card"></i>
                            </div>
                            <h5 class="card-title mb-1">Total Días</h5>
                            <h3 class="mb-0 cantidad-card"><?php echo $total_dias_totales; ?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card card-hover shadow-lg border-0 text-center">
                        <div class="card-body d-flex flex-column align-items-center justify-content-center">
                            <div class="mb-2">
                                <i class="bi bi-calendar-check-fill icono-card"></i>
                            </div>
                            <h5 class="card-title mb-1">Días Disfrutados</h5>
                            <h3 class="mb-0 cantidad-card"><?php echo $total_dias_disfrutados; ?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card card-hover shadow-lg border-0 text-center">
                        <div class="card-body d-flex flex-column align-items-center justify-content-center">
                            <div class="mb-2">
                                <i class="bi bi-cash-coin icono-card"></i>
                            </div>
                            <h5 class="card-title mb-1">Días Pagados en Dinero</h5>
                            <h3 class="mb-0 cantidad-card"><?php echo $total_dias_dinero; ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</body>

</html>
