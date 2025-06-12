<?php

include("php/conexion.php");

$sql = "SELECT nombre_vacante FROM vacantes";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Vacaciones</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="docs/css/estilos.css">
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
</head>

<body>
    <div id="editar-vacaciones">
        <?php
        if (isset($_POST['enviar'])) {

            $cedula = $_POST['id'];
            $dias_total = $_POST['dias_total'];
            $dias_disfrutados = $_POST['dias_disfrutados'];

            $sql = "update vacaciones set dias_total='" . $dias_total . "', dias_disfrutados='" . $dias_disfrutados . "' where id = '" . $cedula . "'";
            $resultado = mysqli_query($conexion, $sql);

            if ($resultado) {
                echo "<script language='JavaScript'>
            alert('Se han actualizado correctamente');
            location.assign('index_admin.php');
            </script>";
            } else {
                echo "<script language='JavaScript'>
            alert('No se han actualizado correctamente');
            location.assign('index_admin.php');
            </script>";
            }
            mysqli_close($conexion);

        } else {
            $id = $_GET['id'];
            $sql = "SELECT * FROM vacaciones where id='" . $id . "'";
            $resultado = mysqli_query($conexion, $sql);

            $fila = mysqli_fetch_assoc($resultado);
            $cedula = $fila["cedula"];
            $dias_total = $fila["dias_total"];
            $dias_disfrutados = $fila["dias_disfrutados"];

            mysqli_close($conexion);

        }


        ?>
        <div class="titulo-editar-vacaciones">
            <h1>Editar Vacaciones</h1>
        </div>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
            <h3>Cedula</h3>
            <input type="text" name="id" class="form-control" readonly value="<?php echo $cedula ?>"><br>

            <h3>Dias Totales</h3>
            <input type="text" name="dias_total" class="form-control" value="<?php echo $dias_total ?>"><br>

            <h3>Dias Disfrutados</h3>
            <input type="text" name="dias_disfrutados" class="form-control" value="<?php echo $dias_disfrutados ?>"><br>

            <input type="hidden" name="id" value="<?php echo $id ?>">

            <div class="botones-editar-vacaciones">

                <button type="submit" class="btn btn-success" name="enviar">Editar</button>
                <a href="index_admin.php" class="btn btn-danger">Regresar</a>

            </div>
    </div>
</body>

</html>