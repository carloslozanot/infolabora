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
    <title>TH</title>
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
                <div class="option" data-pagina="datos">
                    <i class="bi bi-person" title="Datos"></i>
                    <h4>Perfil</h4>
                </div>
            </a>
            <a href="#">
                <div class="option" data-pagina="descargas">
                    <i class="bi bi-download" title="Descargas"></i>
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
                <div class="option" data-pagina="rrhh">
                    <i class="bi bi-briefcase" title="RRHH"></i>
                    <h4>Vacantes</h4>
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
            <p style="font-size: 20px; font-weight:800;">Este es el portal de Recursos Humanos en el cual podrá realizar
                las siguientes acciones:<br><br></p>
            <p style="font-size: 16px;text-align: left;margin-left: 10%;">🔍 Consultar los datos de los integrantes de la compañia</p>
            <p style="font-size: 16px;text-align: left;margin-left: 10%;">📋 Consultar bitacora</p>
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
                    <p class="cargo-empleado-boceto"><?php echo $_SESSION['cargo'] ?? 'Cargo no definido'; ?></p>
                </div>
            </div>

            <div class="seccion-inferior-boceto">
                <div class="subseccion-datos-personales-laborales">
                    <p style="font-size: 32px; font-weight:700;">DATOS PERSONALES
                    </p>
                    <div class="grupo-dato">
                        <div class="icono-con-texto">
                            <div class="icono-circular">
                                <i class="bi bi-at"></i>
                            </div>
                            <div class="texto">
                                <p class="etiqueta-dato">CORREO CORPORATIVO</p>
                                <span class="valor-dato"><?php echo $_SESSION['correo'] ?? ''; ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="grupo-dato">
                        <div class="icono-con-texto">
                            <div class="icono-circular">
                                <i class="bi bi-phone"></i>
                            </div>
                            <div class="texto">
                                <p class="etiqueta-dato">NUMERO CELULAR</p>
                                <span class="valor-dato"><?php echo $_SESSION['celular'] ?? ''; ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="grupo-dato">
                        <div class="icono-con-texto">
                            <div class="icono-circular">
                                <i class="bi bi-person-vcard"></i>
                            </div>
                            <div class="texto">
                                <p class="etiqueta-dato">NUMERO DE DOCUMENTO</p>
                                <span class="valor-dato"><?php echo $_SESSION['usuario'] ?? ''; ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="grupo-dato">
                        <div class="icono-con-texto">
                            <div class="icono-circular">
                                <i class="bi bi-house-door-fill"></i>
                            </div>
                            <div class="texto">
                                <p class="etiqueta-dato">DIRECCIÓN</p>
                                <span class="valor-dato"><?php echo $_SESSION['usuario'] ?? ''; ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="grupo-dato">
                        <div class="icono-con-texto">
                            <div class="icono-circular">
                                <i class="bi bi-calendar-event"></i>
                            </div>
                            <div class="texto">
                                <p class="etiqueta-dato">FECHA INGRESO</p>
                                <span class="valor-dato"><?php echo $_SESSION['fecha_ingreso'] ?? ''; ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="grupo-dato">
                        <div class="icono-con-texto">
                            <div class="icono-circular">
                                <i class="bi bi-pin-map-fill"></i>
                            </div>
                            <div class="texto">
                                <p class="etiqueta-dato">CIUDAD RESIDENCIA</p>
                                <span class="valor-dato"><?php echo $_SESSION['usuario'] ?? ''; ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="grupo-dato">
                        <div class="icono-con-texto">
                            <div class="icono-circular">
                                <i class="bi bi-building"></i>
                            </div>
                            <div class="texto">
                                <p class="etiqueta-dato">AREA</p>
                                <span class="valor-dato"><?php echo $_SESSION['area'] ?? ''; ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="grupo-dato">
                        <div class="icono-con-texto">
                            <div class="icono-circular">
                                <i class="bi bi-person-workspace"></i>
                            </div>
                            <div class="texto">
                                <p class="etiqueta-dato">LIDER INMEDIATO</p>
                                <span class="valor-dato"><?php echo $_SESSION['jefe_inmediato'] ?? ''; ?></span>
                            </div>
                        </div>
                    </div>

                </div>

                <hr class="linea-divisoria-boceto">
                <div class="subseccion-beneficios-boceto">
                    <p style="font-size: 32px; font-weight:700;">BENEFICIOS</p>
                    <div class="grupo-dato">
                        <div class="icono-con-texto">
                            <div class="icono-circular">
                                <i class="bi-briefcase"></i>
                            </div>
                            <div class="texto">
                                <p class="etiqueta-dato">CAJA DE COMPENSACIÓN</p>
                                <span class="valor-dato"><?php echo $_SESSION['caja'] ?? ''; ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="grupo-dato">
                        <div class="icono-con-texto">
                            <div class="icono-circular">
                                <i class="bi bi-hospital"></i>
                            </div>
                            <div class="texto">
                                <p class="etiqueta-dato">EPS</p>
                                <span class="valor-dato"><?php echo $_SESSION['eps'] ?? ''; ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="grupo-dato">
                        <div class="icono-con-texto">
                            <div class="icono-circular">
                                <i class="bi bi-coin"></i>
                            </div>
                            <div class="texto">
                                <p class="etiqueta-dato">PENSIONES</p>
                                <span class="valor-dato"><?php echo $_SESSION['pensiones'] ?? ''; ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="grupo-dato">
                        <div class="icono-con-texto">
                            <div class="icono-circular">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <div class="texto">
                                <p class="etiqueta-dato">ARL</p>
                                <span class="valor-dato"><?php echo $_SESSION['arl'] ?? ''; ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="grupo-dato">
                        <div class="icono-con-texto">
                            <div class="icono-circular">
                                <i class="bi bi-piggy-bank	"></i>
                            </div>
                            <div class="texto">
                                <p class="etiqueta-dato">CESANTIAS</p>
                                <span class="valor-dato"><?php echo $_SESSION['cesantias'] ?? ''; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
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
                <div id="mensaje" style="display: none;">
                </div>
            </form>
        </div>
        <div id="contenido-rrhh" class="contenido" style="display: none;">
            <h2 style="text-align: center;font-size: 40px; font-weight: 1000;">MODULO DE TALENTO HUMANO</h2><br>
            <p style="text-align: center;font-size: 16px;">Estas son las vacantes disponibles actualmente en la compañía
            </p>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $nombre_vacante = $row["nombre_vacante"];
                    echo '<button type="button" class="btn boton-vacantes" onclick="window.location.href=\'vacante.php?nombre=' . urlencode($nombre_vacante) . '\'">' . $nombre_vacante . '</button>';
                }
            } else {
                echo "No hay vacantes disponibles en este momento.";
            }
            ?>
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