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

include("php/conexion.php");

// Realiza una consulta SQL para obtener los nombres de las vacantes.
$sql = "SELECT nombre_vacante FROM vacantes";
$result = mysqli_query($conexion, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Talento Humano</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="docs/css/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body id="body">
    <header class="index">
        <div class="icon_menu">
            <i class="bi bi-code" id="btn_open"></i>
        </div>
    </header>

    <div class="menu_side" id="menu_side">
        <div class="name_page">
            <i class="bi bi-building"></i>
            <h4>Talento Humano</h4>
        </div>
        <div class="options_menu">
            <a href="#">
                <div class="option" data-pagina="inicio">
                    <i class="bi bi-house-door" title="Inicio"></i>
                    <h4>Inicio</h4>
                </div>
            </a>
            <a href="#">
                <div class="option" data-pagina="integrantes">
                    <i class="bi bi-person" title="Integrantes"></i>
                    <h4>Integrantes</h4>
                </div>
            </a>
            <a href="#">
                <div class="option" data-pagina="descargas">
                    <i class="bi bi-download" title="Descargas"></i>
                    <h4>Certificados</h4>
                </div>
            </a>
            <a href="#">
                <div class="option" data-pagina="cerrar-sesion">
                    <i class="bi bi-box-arrow-right" title="cerrar-sesion"></i>
                    <h4>Cerrar Sesion</h4>
                </div>
            </a>
        </div>
    </div>

    <main>
        <div id="contenido-inicio" class="contenido" style="display: block;">
            <p style="font-size: 32px; font-weight:1000;">¡Bienvenido,
                <?php echo $_SESSION['nombreUsuario'] . ' ' . $_SESSION['apellidoUsuario'] . '!'; ?><br><br>
            </p>
            <p style="font-size: 20px; font-weight:800;">Este es el portal de Talento Humano en el cual podrá realizar
                las siguientes acciones:<br><br></p>
            <p style="font-size: 16px;">🔍 Consultar los datos de los integrantes de la compañia</p>
            <p style="font-size: 16px;">📋 Consultar bitacora</p>
        </div>
        <div id="contenido-integrantes" class="contenido" style="display: none;">
            <h2>Lista de Integrantes</h2>
            <br>
            <table class="table table-striped table-bordered table-hover" id="table_id">
                <thead>
                    <tr>
                        <th>Cedula</th>
                        <th>Correo</th>
                        <th>Celular</th>
                        <th>Edad</th>
                        <th>Fecha Ingreso</th>
                        <th>Cargo</th>
                        <th>Area</th>
                    </tr>
                </thead>
                <tbody>

                    <?php

                    include("php/conexion.php");
                    $SQL = "SELECT * FROM integrantes e";
                    $dato = mysqli_query($conexion, $SQL);

                    if ($dato->num_rows > 0) {
                        while ($fila = mysqli_fetch_array($dato)) {
                            ?>
                            <tr>
                                <td>
                                    <?php echo $fila['cedula']; ?>
                                </td>
                                <td>
                                    <?php echo $fila['correo']; ?>
                                </td>
                                <td>
                                    <?php echo $fila['celular']; ?>
                                </td>
                                <td>
                                    <?php echo $fila['edad']; ?>
                                </td>
                                <td>
                                    <?php echo $fila['fecha_ingreso']; ?>
                                </td>
                                <td>
                                    <?php echo $fila['cargo']; ?>
                                </td>
                                <td>
                                    <?php echo $fila['area']; ?>
                                </td>

                                <td>
                                    <a class="btn btn-warning" href="editar_integrante.php?id=<?php echo $fila['cedula'] ?> "><i
                                            class="fa-solid fa-pen-to-square"></i>
                                        Editar </a> <br>

                                    <a class="btn btn-danger" href="eliminar_integrante.php?id=<?php echo $fila['cedula'] ?>"
                                        onclick='return confirmar()'><i class="fa-solid fa-trash"></i>
                                        Eliminar</a><br>

                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>


                </tbody>
            </table>
            <br>
            <div>
                <a class="btn btn-success" href="agregar_integrante.php"><i class="fa-solid fa-plus"></i> Agregar
                    Integrante
                </a>
            </div>
        </div>
        <div id="contenido-descargas" class="contenido" style="display: none;">
            <h2 style="text-align: center;font-size: 40px; font-weight: 1000;">CERTIFICADOS</h2><br>
            <p style="text-align: center;font-size: 18px;font-weight:300;">En esta pestaña puede descargar desprendibles
                de pago bajo el mes que necesite y certificados laborales para quien interese</p>
            <div>
                <a href="desprendible_pago.php" target="_blank" class="btn boton-descargas"><i
                        class="fa-solid fa-file-invoice-dollar"></i> DESPRENDIBLES DE PAGO</a>
                <a href="certificado_laboral.php" target="_blank" class="btn boton-descargas"><i
                        class="fa-solid fa-file-circle-check"></i> CERTIFICADO LABORAL</a>
            </div>
        </div>

        <div id="contenido-cerrar-sesion" class="contenido" style="display: none;">
            <br>
            <label style="display: block; text-align: center;font-weight: bold; font-size: 40px">¿Esta seguro de cerrar
                sesion?</label><br>
            <a href="php/cerrar_sesion.php" class="btn btn-danger"><i class="fa-solid fa-right-from-bracket"></i> CERRAR
                SESION</a>
        </div>
    </main>

    <!-- Incluye el archivo JavaScript -->
    <script src="docs/js/script.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#formulario').submit(function (event) {
                event.preventDefault(); // Evitar el envío del formulario por el método tradicional

                var formData = new FormData($(this)[0]);

                $.ajax({
                    url: 'cargar_documento.php',
                    type: 'POST',
                    data: formData,
                    async: true,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        $('#mensaje').html(response).show(); // Mostrar el mensaje y el contenedor
                    },
                    error: function () {
                        $('#mensaje').text('Error al subir el archivo').show(); // Mostrar un mensaje de error en caso de fallo
                    }
                });
            });
        });
    </script>
    <script>
        function mostrarFormulario() {
            var formulario = document.getElementById("formulario");
            formulario.style.display = "block";
        }
    </script>

</body>

</html>