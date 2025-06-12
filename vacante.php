<?php
include("php/conexion.php");

// Recupera el nombre de la vacante desde la URL.
if (isset($_GET['nombre'])) {
    $nombre_vacante = $_GET['nombre'];

    // Realiza una consulta SQL para obtener la URL de la imagen y la fecha de la vacante.
    $sql = "SELECT imagen, fecha_publicacion, prueba_aptitudes FROM vacantes WHERE nombre_vacante = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "s", $nombre_vacante);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $imagen, $fecha_publicacion, $prueba_aptitudes);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
} else {
    $imagen = null; // Asigna un valor por defecto si no se especifica el nombre de la vacante
    $fecha_publicacion = null; // Asigna un valor por defecto si no se especifica el nombre de la vacante
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vacantes</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="docs/css/estilos.css">
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="contenido-vacante">
        <h2 style="text-align: center;font-size: 40px; font-weight: 1000;">VACANTE DISPONIBLE</h2><br>
        <h2 style="text-align: center;font-size: 20px; font-weight: 500;">Publicada el:
            <?php echo $fecha_publicacion; ?>
        </h2>
        <?php
        // Muestra la imagen si existe
        if (!empty($imagen)) {
            echo '<img src="' . $imagen . '" alt="Imagen de la vacante ' . $nombre_vacante . '">';
        } else {
            echo "No se encontró una imagen para esta vacante.";
        }
        ?>
        <p>
            <a href="<?php echo $prueba_aptitudes; ?>" download="prueba-tecnica.pdf">
                <br> <button type="button" class="btn boton-pruebas">PRUEBA TECNICA</button>
            </a>
        </p>
        <p>
            <a href="<?php echo $prueba_aptitudes; ?>" download="prueba-aptitudes.pdf">
                <button type="button" class="btn boton-pruebas">PRUEBA DE APTITUDES/PSICOTECNICA</button>
            </a>
        </p>

        <p>
            <a href="index_rrhh.php">
                <button type="button" class="btn btn-danger">VOLVER</button>
            </a>
        </p>

    </div>
    <!-- El contenido de tu página -->
</body>

</html>