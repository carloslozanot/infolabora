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

// Cédula del usuario en sesión
$cedula = $_SESSION['cedula'];
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

            <div id="contenido-integrantes" class="contenido">
                <h2>Mis Certificados</h2><br>

                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Cédula</th>
                            <th>Tipo</th>
                            <th>Valor</th>
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
                                echo "<td><a href='{$fila['valor']}' target='_blank'>Ver documento</a></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3'>No hay certificados disponibles</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="container my-3">
                <div class="boton-certificado-lab d-flex justify-content-center">
                    <a href="index_th.php" class="btn btn-danger">Regresar</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
