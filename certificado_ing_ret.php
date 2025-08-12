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
    <title>Certificado de Ingresos y Retenciones</title>
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
            <h2 style="font-size: 35px; font-weight: 700;">CERTIFICADO DE INGRESOS Y RETENCIONES</h2>
            <p class="subtitulo-desprendible">Seleccione el año que desea generar</p>

            <form method="post" action="fpdf/desprendible.php" class="mt-4" target="_blank">
                <div class="form-group">
                    <select name="ano" class="form-control custom-select-desprendible" required>
                        <option selected disabled>SELECCIONE EL AÑO</option>
                        <?php
                        $query = "SELECT año FROM certificados WHERE cedula = '$cedula' AND tipo = 'Ingresos y Retenciones' ORDER BY año DESC";
                        $resultado = mysqli_query($conexion, $query);

                        if ($resultado && mysqli_num_rows($resultado) > 0) {
                            while ($row = mysqli_fetch_assoc($resultado)) {
                                $anio = $row['año'];
                                echo "<option value='$anio'>$anio</option>";
                            }
                        } else {
                            echo "<option disabled>No hay años disponibles</option>";
                        }
                        ?>
                    </select>
                </div>

                <input type="hidden" name="id" value="<?php echo $cedula; ?>">

                <button type="submit" class="btn boton-certificados mt-3">
                    <i class="fa-solid fa-file"></i> GENERAR CERTIFICADO
                </button>
            </form>
            <div class="container my-3">
                <div class="boton-certificado-lab d-flex justify-content-center">
                    <a href="index_integrante.php" class="btn btn-danger">Regresar</a>
                </div>
            </div>
        </div>
    </div>

</body>

</html>