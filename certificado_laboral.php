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

// Obtén el ID del usuario desde la variable de sesión
$cedula = $_SESSION['usuario'];

// Conexión a la base de datos
include '../php/conexion.php';

$archivo_certificado = 'fpdf/certificado.php'; // Valor por defecto

$consulta = "SELECT integral FROM info_empleados WHERE cedula = '$cedula'";
$resultado = mysqli_query($conexion, $consulta);

if ($resultado && $fila = mysqli_fetch_assoc($resultado)) {
    if (strtoupper(trim($fila['integral'])) === 'SI') {
        $archivo_certificado = 'fpdf/certificado_integral.php';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado Laboral</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="docs/css/estilos.css">
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="contenido-certificado">
        <h2 style="text-align: center; font-size: 35px; font-weight: 1000;">CERTIFICADO LABORAL</h2><br>

        <form method="post" action="fpdf/certificado.php">
        <input type="text" name="destinatario" class="form-control" aria-label="Destinatario" style="width: 450px; height: 30px;" placeholder="Escriba a quién va dirigido">


            <input type="hidden" name="id" value="<?php echo $cedula; ?>">

            <button type="submit" class="btn boton-certificado"><i class="fa-solid fa-file"></i> GENERAR
                CERTIFICADO</button>
        </form>
    </div>
</body>

</html>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado Laboral</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="docs/css/estilos.css">
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="contenido-certificado">
        <h2 style="text-align: center; font-size: 35px; font-weight: 1000;">CERTIFICADO LABORAL</h2><br>

        <form method="post" action="<?php echo $archivo_certificado; ?>">
            <input type="text" name="destinatario" class="form-control" aria-label="Destinatario" style="width: 450px; height: 30px;" placeholder="Escriba a quién va dirigido">
            <input type="hidden" name="id" value="<?php echo $cedula; ?>">
            <button type="submit" class="btn boton-certificado"><i class="fa-solid fa-file"></i> GENERAR CERTIFICADO</button>
        </form>
    </div>
</body>
</html>
