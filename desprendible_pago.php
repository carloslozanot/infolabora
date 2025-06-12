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
$cedula = $_SESSION['usuario']; // Asumiendo que 'usuario' contiene el ID del usuario

?>

<!DOCTYPE html>
<html lang="en">

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
        <h2 style="text-align: center; font-size: 35px; font-weight: 1000;">DESPRENDIBLE</h2><br>

        <form method="post" action="fpdf/desprendible.php">
            <select name="mes" class="form-select form-select-sm" aria-label=".form-select-sm example"
                style="width: 250px; height: 30px;">
                <option selected><b>SELECCIONE EL MES<b></option>
                <option value="Enero-2023">Enero 2023</option>
                <option value="Febrero-2023">Febrero 2023</option>
                <option value="Marzo-2023">Marzo 2023</option>
                <option value="Abril-2023">Abril 2023</option>
                <option value="Mayo-2023">Mayo 2023</option>
                <option value="Junio-2023">Junio 2023</option>
                <option value="Julio-2023">Julio 2023</option>
                <option value="Agosto-2023">Agosto 2023</option>
                <option value="Septiembre-2023">Septiembre 2023</option>
                <option value="Octubre-2023">Octubre 2023</option>
            </select>

            <input type="hidden" name="id" value="<?php echo $cedula; ?>">

            <button type="submit" class="btn boton-certificado"><i class="fa-solid fa-file"></i> GENERAR
                DESPRENDIBLE</button>
        </form>
    </div>
</body>

</html>