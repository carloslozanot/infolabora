<?php
session_start();
include("php/conexion.php");

if (!isset($_SESSION['usuario'])) {
    echo '<p>Debe iniciar sesión.</p>';
    exit;
}

if (isset($_GET['cedula'])) {
    $cedula = intval($_GET['cedula']);
} else {
    die("No se recibió la cédula");
}
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
    <div class="container mt-5">
        <div class="card shadow-lg p-4">
            <h2 class="text-center">CERTIFICADO DE INGRESOS Y RETENCIONES</h2>
            <h4 class="mt-4">Certificados</h4>

            <table class="table table-striped table-bordered table-hover mt-3">
                <thead>
                    <tr>
                        <th>Cédula</th>
                        <th>Tipo</th>
                        <th>Valor</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $SQL = "SELECT * FROM certificados WHERE cedula = '$cedula'";
                    $dato = mysqli_query($conexion, $SQL);

                    if ($dato && $dato->num_rows > 0) {
                        while ($fila = mysqli_fetch_assoc($dato)) {
                            echo "<tr>";
                            echo "<td>{$fila['cedula']}</td>";
                            echo "<td>{$fila['tipo']}</td>";

                            if (!empty($fila['valor'])) {
                                echo "<td><a href='{$fila['valor']}' target='_blank'>Ver documento</a></td>";
                                echo "<td><a href='{$fila['valor']}' target='_blank' class='btn btn-primary btn-sm'>Ver</a></td>";
                            } else {
                                echo "<td>Sin documento</td>";
                                echo "<td><a href='cargar_certificado.php?id={$fila['id']}' class='btn btn-warning btn-sm'>Cargar</a></td>";
                            }

                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No hay certificados disponibles</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

            <div class="text-center">
                <a href="index_th.php" class="btn btn-danger">Regresar</a>
            </div>
        </div>
    </div>
</body>
</html>