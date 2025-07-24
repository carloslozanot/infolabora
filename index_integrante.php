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
    <title>Integrante</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="docs/css/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


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
            <h4>Integrante</h4>
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
                    <i class="bi bi-person" title="Datos"></i>
                    <h4>Perfil</h4>
                </div>
            </a>
            <a href="#">
                <div class="option" data-pagina="certificados">
                    <i class="bi bi-download" title="Certificados"></i>
                    <h4>Certificados</h4>
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
            <div class="row align-items-center seccion-cerrar-sesion">
                <p style="font-size: 32px; font-weight:1000;">¡Bienvenido,
                    <?php echo $_SESSION['nombreUsuario'] . ' ' . $_SESSION['apellidoUsuario'] . '!'; ?><br><br>
                </p>
                <p style="font-size: 20px;">Este es el <strong>portal corporativo</strong>, a través del cual podrás
                    realizar las siguientes acciones:<br><br></p>
                <p style="font-size: 16px;">📌 Consultar tus datos personales relacionados con la compañía</p>
                <p style="font-size: 16px;">📥 Descargar documentos corporativos</p>
                <p style="font-size: 16px;">🌴 Consultar y validar los días de vacaciones pendientes por tomar.</p>
            </div>
        </div>
        <div id="contenido-datos" class="contenido" style="display: none;">
            <div class="seccion-superior-boceto">
                <div class="empleado-foto-boceto">
                    <img src="<?php echo $_SESSION['imagen'] ?? 'placeholder.png'; ?>" alt="Foto del empleado">
                </div>
                <div class="empleado-nombre-cargo">
                    <p class="nombre-empleado-boceto"><?php echo $_SESSION['nombreUsuario'] ?? ''; ?>
                        <?php echo $_SESSION['apellidoUsuario'] ?? ''; ?>
                    </p>
                    <p class="cargo-empleado-boceto"><?php echo $_SESSION['cargo'] ?? 'Cargo no definido'; ?>
                    </p>
                </div>
            </div>

            <div class="seccion-inferior-boceto">
                <div class="datos-personales-container">
                    <p class="titulo-datos">DATOS PERSONALES</p>
                    <div class="datos-grid">
                        <div class="grupo-dato">
                            <div class="icono-circular"><i class="bi bi-at"></i></div>
                            <div class="texto">
                                <span class="valor-dato"><?php echo $_SESSION['correo'] ?? ''; ?></span>
                                <p class="etiqueta-dato">CORREO CORPORATIVO</p>
                            </div>
                        </div>
                        <div class="grupo-dato">
                            <div class="icono-circular"><i class="bi bi-person-vcard"></i></div>
                            <div class="texto">
                                <span class="valor-dato"><?php echo $_SESSION['usuario'] ?? ''; ?></span>
                                <p class="etiqueta-dato">NÚMERO DE DOCUMENTO</p>
                            </div>
                        </div>
                        <div class="grupo-dato">
                            <div class="icono-circular"><i class="bi bi-house-door-fill"></i></div>
                            <div class="texto">
                                <span class="valor-dato"><?php echo $_SESSION['direccion'] ?? ''; ?></span>
                                <p class="etiqueta-dato">DIRECCIÓN</p>
                            </div>
                        </div>
                        <div class="grupo-dato">
                            <div class="icono-circular"><i class="bi bi-house-door-fill"></i></div>
                            <div class="texto">
                                <span class="valor-dato"><?php echo $_SESSION['ciudad_residencia'] ?? ''; ?></span>
                                <p class="etiqueta-dato">CIUDAD DE RESIDENCIA</p>
                            </div>
                        </div>
                        <div class="grupo-dato">
                            <div class="icono-circular"><i class="bi bi-phone"></i></div>
                            <div class="texto">
                                <span class="valor-dato"><?php echo $_SESSION['celular'] ?? ''; ?></span>
                                <p class="etiqueta-dato">NÚMERO CELULAR</p>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="linea-divisoria-boceto">
                <div class="datos-personales-container">
                    <p class="titulo-datos">DATOS LABORALES</p>
                    <div class="datos-grid">
                        <div class="grupo-dato">
                            <div class="icono-circular">
                                <i class="bi bi bi-file-earmark-check"></i>
                            </div>
                            <div class="texto">
                                <span class="valor-dato"><?php echo $_SESSION['tipo_contrato'] ?? ''; ?></span>
                                <p class="etiqueta-dato">TIPO DE CONTRATO</p>
                            </div>
                        </div>
                        <div class="grupo-dato">
                            <div class="icono-circular">
                                <i class="bi bi-calendar-event"></i>
                            </div>
                            <div class="texto">
                                <span class="valor-dato">
                                    <?php
                                    if (!empty($_SESSION['fecha_ingreso'])) {
                                        $fecha_cruda = $_SESSION['fecha_ingreso']; // formato: Y-m-d
                                        $fecha_obj = DateTime::createFromFormat('Y-m-d', $fecha_cruda);
                                        $meses = [
                                            '01' => 'Enero',
                                            '02' => 'Febrero',
                                            '03' => 'Marzo',
                                            '04' => 'Abril',
                                            '05' => 'Mayo',
                                            '06' => 'Junio',
                                            '07' => 'Julio',
                                            '08' => 'Agosto',
                                            '09' => 'Septiembre',
                                            '10' => 'Octubre',
                                            '11' => 'Noviembre',
                                            '12' => 'Diciembre'
                                        ];
                                        $dia = $fecha_obj->format('d');
                                        $mes = $meses[$fecha_obj->format('m')];
                                        $anio = $fecha_obj->format('Y');
                                        echo "$dia de $mes del $anio";
                                    } else {
                                        echo "Fecha no disponible";
                                    }
                                    ?>
                                </span>
                                <p class="etiqueta-dato">FECHA DE INGRESO</p>
                            </div>
                        </div>
                        <div class="grupo-dato">
                            <div class="icono-circular">
                                <i class="bi bi-person-workspace"></i>
                            </div>
                            <div class="texto">
                                <span class="valor-dato"><?php echo $_SESSION['area'] ?? ''; ?></span>
                                <p class="etiqueta-dato">ÁREA</p>
                            </div>
                        </div>
                        <div class="grupo-dato">
                            <div class="icono-circular">
                                <i class="bi bi-person-workspace"></i>
                            </div>
                            <div class="texto">
                                <span class="valor-dato"><?php echo $_SESSION['lider_inmediato'] ?? ''; ?></span>
                                <p class="etiqueta-dato">LÍDER INMEDIATO</p>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="linea-divisoria-boceto">
                <div class="datos-personales-container">
                    <p class="titulo-datos">BENEFICIOS</p>
                    <div class="datos-grid">
                        <div class="grupo-dato">
                            <div class="icono-circular">
                                <i class="bi-briefcase"></i>
                            </div>
                            <div class="texto">
                                <span class="valor-dato"><?php echo $_SESSION['caja'] ?? ''; ?></span>
                                <p class="etiqueta-dato">CAJA DE COMPENSACIÓN</p>
                            </div>
                        </div>
                        <div class="grupo-dato">
                            <div class="icono-circular">
                                <i class="bi bi-hospital"></i>
                            </div>
                            <div class="texto">
                                <span class="valor-dato"><?php echo $_SESSION['eps'] ?? ''; ?></span>
                                <p class="etiqueta-dato">EPS</p>
                            </div>
                        </div>
                        <div class="grupo-dato">
                            <div class="icono-circular">
                                <i class="bi bi-coin"></i>
                            </div>
                            <div class="texto">
                                <span class="valor-dato"><?php echo $_SESSION['pensiones'] ?? ''; ?></span>
                                <p class="etiqueta-dato">PENSIONES</p>
                            </div>
                        </div>
                        <div class="grupo-dato">
                            <div class="icono-circular">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <div class="texto">
                                <span class="valor-dato"><?php echo $_SESSION['arl'] ?? ''; ?></span>
                                <p class="etiqueta-dato">ARL</p>
                            </div>
                        </div>
                        <div class="grupo-dato">
                            <div class="icono-circular">
                                <i class="bi bi-piggy-bank	"></i>
                            </div>
                            <div class="texto">
                                <span class="valor-dato"><?php echo $_SESSION['cesantias'] ?? ''; ?></span>
                                <p class="etiqueta-dato">CESANTIAS</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="contenido-certificados" class="contenido" style="display: none;">
            <div class="tarjeta-certificados">
                <div class="col-md-6 text-center">
                    <img src="docs/img/certificado-icono.png" alt="Ilustración certificados">
                </div>
                <div class="texto-certificados">
                    <h2 class="font-weight-bold" style="font-size: 36px; color:#150940;">CERTIFICADOS</h2>
                    <p class="descripcion-certificados">
                        En esta pestaña puede descargar certificados laborales a quien interese.
                    </p>
                    <div class="d-flex flex-column gap-3">
                        <a href="certificado_laboral.php" target="_blank" class="btn boton-certificado">
                            <i class="fa-solid fa-file-circle-check"></i> CERTIFICADO LABORAL
                        </a>
                        <a href="desprendible_pago.php" target="_blank" class="btn boton-certificado">
                            <i class="fa-solid fa-file-invoice-dollar"></i> DESPRENDIBLE DE PAGO
                        </a>
                    </div>
                </div>
            </div>
        </div>


        <div id="contenido-vacaciones" class="contenido container my-5" style="display: none;">
            <div class="row align-items-center seccion-vacaciones">

                <div class="col-md-6 text-center text-md-left mb-4 mb-md-0">
                    <h2 class="font-weight-bold" style="font-size: 36px; color:#150940;">VACACIONES</h2>
                    <div class="dias-pendientes-circle mx-auto my-4">
                        <?php echo $_SESSION['diferencia_dias']; ?>
                    </div>
                    <p class="h5 mb-4">Días pendientes por disfrutar</p>

                    <div class="d-flex flex-column gap-3">
                        <a href="detalle_vacaciones.php" target="_blank" class="btn boton-vacaciones mb-2">
                            <i class="fa-solid fa-clipboard-list"></i> DETALLE
                        </a>
                        <a href="solicitar_vacaciones.php" target="_blank" class="btn boton-vacaciones mb-2">
                            <i class="fa-solid fa-file-signature"></i> SOLICITAR VACACIONES
                        </a>
                        <a href="historial_vacaciones.php" target="_blank" class="btn boton-vacaciones">
                            <i class="fa-solid fa-book-open"></i> HISTORIAL DE SOLICITUDES
                        </a>
                    </div>
                </div>

                <div class="col-md-6 text-center">
                    <img src="docs/images/vacaciones.png" alt="Ilustración vacaciones" class="vacaciones-img">
                </div>

            </div>
        </div>




        <div id="contenido-cerrar-sesion" class="contenido" style="display: none;">
            <div class="row align-items-center seccion-cerrar-sesion">
                <br>
                <label style="display: block; text-align: center;font-weight: 700; font-size: 40px">¿Esta seguro de
                    cerrar
                    sesion?</label><br>
                <a href="php/cerrar_sesion.php" class="btn btn-danger"><i class="fa-solid fa-right-from-bracket"></i>
                    CERRAR
                    SESION</a>
            </div>
        </div>

    </main>

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