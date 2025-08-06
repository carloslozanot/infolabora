<?php

session_start();

include("php/conexion.php");

if (!isset($_SESSION['usuario'])) {
    echo '
        <script>
            alert("Debe iniciar sesión");
            window.location = "index.php";
        </script>
    ';
    exit;
}

// Obtener el ID del usuario desde la sesión
$cedula = $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desprendible</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="docs/css/estilos.css">
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="contenido-desprendible container mt-5">
        <div class="card shadow-lg p-4 seccion-certificados text-center">
            <h2 style="font-size: 35px; font-weight: 700;">DESPRENDIBLE DE PAGO</h2>
            <p class="subtitulo-desprendible">Seleccione el periodo que desea generar</p>

            <form method="post" action="fpdf/desprendible.php" class="mt-4" target="_blank">
                <div class="form-group">
                    <select name="periodo" class="form-control custom-select-desprendible" required>
                        <option selected disabled>SELECCIONE EL PERIODO</option>
                        <?php
                        $query = "SELECT periodo FROM desprendibles WHERE cedula = '$cedula' ORDER BY periodo DESC";
                        $resultado = mysqli_query($conexion, $query);

                        $meses = [
                            '01' => 'Enero',
                            '02' => 'Febrero',
                            '03' => 'Marzo',
                            '04' => 'Abril',
                            '05' => 'Mayo',
                            '06' => 'Junio',
                            '07' => 'Julio',
                            '08' => 'Agosto',
                            '09' => 'Septiembre',
                            '10' => 'Octubre',
                            '11' => 'Noviembre',
                            '12' => 'Diciembre'
                        ];

                        if ($resultado && mysqli_num_rows($resultado) > 0) {
                            while ($row = mysqli_fetch_assoc($resultado)) {
                                $periodo = $row['periodo'];
                                $anio = substr($periodo, 0, 4);
                                $mes = substr($periodo, 4, 2);
                                $mesNombre = $meses[$mes] ?? 'Mes inválido';
                                echo "<option value='$periodo'>$mesNombre-$anio</option>";
                            }
                        } else {
                            echo "<option disabled>No hay periodos disponibles</option>";
                        }
                        ?>
                    </select>
                </div>

                <input type="hidden" name="id" value="<?php echo $cedula; ?>">

                <button type="submit" class="btn boton-certificados mt-3">
                    <i class="fa-solid fa-file"></i> GENERAR DESPRENDIBLE
                </button>
            </form>
            <div class="container my-2">
                <div class="boton-certificado-lab d-flex justify-content-center">
                    <a href="index_integrante.php" class="btn btn-danger">Regresar</a>
                </div>
            </div>
        </div>
    </div>

</body>

</html>