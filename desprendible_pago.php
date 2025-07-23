<?php

session_start();

include("conexion.php");

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
    <div class="contenido-desprendible">
        <h2 style="text-align: center; font-size: 35px; font-weight: 1000;">DESPRENDIBLE <?php echo $cedula; ?></h2>

        <form method="post" action="fpdf/desprendible.php">
            <select name="mes" class="form-select form-select-sm" style="width: 250px; height: 30px;">
                <option selected disabled>SELECCIONE EL MES</option>

                <?php

                $query = "SELECT mes FROM desprendibles WHERE cedula = '$cedula' ORDER BY mes DESC";
                $resultado = mysqli_query($conexion, $query);

                if ($resultado && mysqli_num_rows($resultado) > 0) {
                    while ($row = mysqli_fetch_assoc($resultado)) {
                        $mes = $row['mes'];
                        echo "<option value='$mes'>$mes</option>";
                    }
                } else {
                    echo "<option disabled>No hay meses disponibles para la cédula $cedula</option>";

                }
                ?>
            </select>


            <input type="hidden" name="id" value="<?php echo $cedula; ?>">

            <button type="submit" class="btn boton-certificado">
                <i class="fa-solid fa-file"></i> GENERAR DESPRENDIBLE
            </button>
        </form>
    </div>
</body>

</html>