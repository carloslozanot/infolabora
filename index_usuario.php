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


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
            <i class="bi bi-person"></i>
            <h4>Colaborador</h4>
        </div>
        <div class="options_menu">
            <a href="#">
                <div class="option" data-pagina="inicio">
                    <i class="bi bi-house-door" title="Inicio"></i>
                    <h4>Inicio</h4>
                </div>
            </a>
            <a href="#">
                <div class="option" data-pagina="datos">
                    <i class="bi bi-database" title="Datos"></i>
                    <h4>Datos</h4>
                </div>
            </a>
            <a href="#">
                <div class="option" data-pagina="descargas">
                    <i class="bi bi-download" title="Descargas"></i>
                    <h4>Descargas</h4>
                </div>
            </a>
            <a href="#">
                <div class="option" data-pagina="vacaciones">
                    <i class="bi bi-umbrella" title="Vacaciones"></i>
                    <h4>Vacaciones</h4>
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
            <p style="font-size: 20px;">Este es el <strong>portal corporativo</strong>, a través del cual podrás realizar las siguientes acciones:<br><br></p>
            <p style="font-size: 16px;text-align: left;margin-left: 10%;">* Consultar tus datos personales relacionados con la compañía</p>
            <p style="font-size: 16px;text-align: left;margin-left: 10%;">* Descargar documentos corporativos</p>
            <p style="font-size: 16px;text-align: left;margin-left: 10%;">* Consultar y validar los días de vacaciones pendientes por tomar.</p>
        </div>
        <div id="contenido-datos" class="container py-4" style="display: none;">
    <div class="card shadow-lg p-4">
        <div class="row g-4">
            <div class="col-md-3 text-center">
                <img src="<?php echo $_SESSION['imagen'] ?>" alt="Foto del empleado" class="img-fluid rounded-circle border border-3 border-primary">
            </div>
            <div class="col-md-9">
                <div class="mb-4">
                    <h4 class="fw-bold text-primary">Información Personal</h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>NOMBRES:</strong> <?php echo $_SESSION['nombreUsuario'] ?></li>
                        <li class="list-group-item"><strong>APELLIDOS:</strong> <?php echo $_SESSION['apellidoUsuario'] ?></li>
                        <li class="list-group-item"><strong>DOCUMENTO:</strong> <?php echo $_SESSION['usuario'] ?></li>
                        <li class="list-group-item"><strong>NUMERO CELULAR:</strong> <?php echo $_SESSION['celular'] ?></li>
                        <li class="list-group-item"><strong>EDAD:</strong> <?php echo $_SESSION['edad'] ?></li>
                    </ul>
                </div>

                <div class="mb-4">
                    <h4 class="fw-bold text-success">Información Laboral</h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>CORREO ELECTRÓNICO:</strong> <?php echo $_SESSION['correo'] ?></li>
                        <li class="list-group-item"><strong>FECHA INGRESO:</strong> <?php echo $_SESSION['fecha_ingreso'] ?></li>
                        <li class="list-group-item"><strong>CARGO:</strong> <?php echo $_SESSION['cargo'] ?></li>
                        <li class="list-group-item"><strong>ÁREA:</strong> <?php echo $_SESSION['area'] ?></li>
                        <li class="list-group-item"><strong>JEFE INMEDIATO:</strong> <?php echo $_SESSION['jefe_inmediato'] ?></li>
                    </ul>
                </div>

                <div>
                    <h4 class="fw-bold text-info">Beneficios</h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>CAJA DE COMPENSACIÓN:</strong> <?php echo $_SESSION['caja'] ?></li>
                        <li class="list-group-item"><strong>EPS:</strong> <?php echo $_SESSION['eps'] ?></li>
                        <li class="list-group-item"><strong>ARL:</strong> <?php echo $_SESSION['arl'] ?></li>
                        <li class="list-group-item"><strong>PENSIONES:</strong> <?php echo $_SESSION['pensiones'] ?></li>
                        <li class="list-group-item"><strong>CESANTÍAS:</strong> <?php echo $_SESSION['cesantias'] ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

        <div id="contenido-descargas" class="contenido" style="display: none;">
            <h2 style="text-align: center;font-size: 40px; font-weight: 1000;">DESCARGAS</h2><br>
            <p style="text-align: center;font-size: 18px;font-weight:300;">En esta pestaña puede descargar desprendibles
                de pago bajo el mes que necesite y certificados laborales para quien interese</p>
            <div>
                <a href="desprendible_pago.php" target="_blank" class="btn boton-descargas"><i
                        class="fa-solid fa-file-invoice-dollar"></i> DESPRENDIBLES DE PAGO</a>
                <a href="certificado_laboral.php" target="_blank" class="btn boton-descargas"><i
                        class="fa-solid fa-file-circle-check"></i> CERTIFICADO LABORAL</a>
            </div>
        </div>
        <div id="contenido-vacaciones" class="contenido" style="display: none;">
            <h2 style="text-align: center;font-size: 40px; font-weight: 1000;">VACACIONES</h2>
            <br>
            <p style="text-align: center; font-size: 20px; font-weight: bold;">Días Totales:
                <?php echo $_SESSION['dias_total'] . ' días'; ?>
            </p>
            <p style="text-align: center; font-size: 20px; font-weight: bold;">Días Disfrutados:
                <?php echo $_SESSION['dias_disfrutados'] . ' días'; ?>
            </p>
            <p style="font-size: 100px; font-weight: bold; text-align: center;margin-bottom: 0px;color:#150940">
                <?php echo $_SESSION['diferencia_dias']; ?>
            </p>
            <p style="font-size: 25px; font-weight: bold; text-align: center;">Dias pendientes por disfrutar
            </p>
            <p style="text-align: center;">
                <a href="docs/documents/GH.AUS.FO.01.Solicitud.de.Ausentismo.docx"
                    download="GH.AUS.FO.01.Solicitud.de.Ausentismo.docx" onclick="mostrarFormulario()">
                    <button type="button" class="btn boton-azul"> <i class="fa-solid fa-file-excel"></i> FORMATO
                        AUSENTISMO</button>
                </a>

            </p>
            <form id="formulario" action="cargar_documento.php" method="post" enctype="multipart/form-data"
                style="display: none;">
                <p style="text-align: center;">
                    <br>
                <p style="font-size: 25px; font-weight: bold; text-align: center;">Subir documento </p>
                <input class="form-control" type="file" id="documento" name="documento">
                <!-- Agregado el atributo name="documento" -->
                <br>
                <button type="submit" class="btn boton-azul" style="display: block; margin: 0 auto;"><i
                        class="fa fa-upload"></i> SUBIR</button>
                </p>

                <!-- Contenedor para mostrar el mensaje de éxito o error -->
                <<div id="mensaje" style="display: none;">
        </div>
        </form>
        </div>

        <div id="contenido-cerrar-sesion" class="contenido" style="display: none;">
            <br>
            <label style="display: block; text-align: center;font-weight: 800; font-size: 40px">¿Esta seguro de cerrar sesion?</label><br>
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