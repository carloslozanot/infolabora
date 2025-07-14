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
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="docs/css/estilos.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <div class="card shadow p-4">
            <h2 class="text-primary font-weight-bold mb-3">Bienvenido, <?php echo $_SESSION['nombreUsuario'] . ' ' . $_SESSION['apellidoUsuario']; ?>!</h2>
            <p class="lead">Este es el <strong>portal corporativo</strong> donde puedes realizar las siguientes acciones:</p>
            <ul class="list-group list-group-flush mt-3">
                <li class="list-group-item">📌 Consultar tus datos personales relacionados con la compañía</li>
                <li class="list-group-item">📥 Descargar documentos corporativos</li>
                <li class="list-group-item">🌴 Consultar y validar los días de vacaciones pendientes</li>
            </ul>
        </div>

        <div class="row mt-5">
            <div class="col-md-4 text-center">
                <img src="<?php echo $_SESSION['imagen'] ?>" class="img-thumbnail rounded-circle" alt="Foto del empleado" width="200">
            </div>
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-header bg-primary text-white font-weight-bold">INFORMACIÓN PERSONAL</div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Nombres:</strong> <?php echo $_SESSION['nombreUsuario'] ?></li>
                        <li class="list-group-item"><strong>Apellidos:</strong> <?php echo $_SESSION['apellidoUsuario'] ?></li>
                        <li class="list-group-item"><strong>Documento:</strong> <?php echo $_SESSION['usuario'] ?></li>
                        <li class="list-group-item"><strong>Celular:</strong> <?php echo $_SESSION['celular'] ?></li>
                        <li class="list-group-item"><strong>Edad:</strong> <?php echo $_SESSION['edad'] ?></li>
                    </ul>
                </div>

                <div class="card mb-3">
                    <div class="card-header bg-success text-white font-weight-bold">INFORMACIÓN LABORAL</div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Correo:</strong> <?php echo $_SESSION['correo'] ?></li>
                        <li class="list-group-item"><strong>Ingreso:</strong> <?php echo $_SESSION['fecha_ingreso'] ?></li>
                        <li class="list-group-item"><strong>Cargo:</strong> <?php echo $_SESSION['cargo'] ?></li>
                        <li class="list-group-item"><strong>Área:</strong> <?php echo $_SESSION['area'] ?></li>
                        <li class="list-group-item"><strong>Jefe:</strong> <?php echo $_SESSION['jefe_inmediato'] ?></li>
                    </ul>
                </div>

                <div class="card">
                    <div class="card-header bg-info text-white font-weight-bold">BENEFICIOS</div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Caja:</strong> <?php echo $_SESSION['caja'] ?></li>
                        <li class="list-group-item"><strong>EPS:</strong> <?php echo $_SESSION['eps'] ?></li>
                        <li class="list-group-item"><strong>ARL:</strong> <?php echo $_SESSION['arl'] ?></li>
                        <li class="list-group-item"><strong>Pensiones:</strong> <?php echo $_SESSION['pensiones'] ?></li>
                        <li class="list-group-item"><strong>Cesantías:</strong> <?php echo $_SESSION['cesantias'] ?></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="text-center mt-5">
            <h2 class="text-info">DESCARGAS</h2>
            <p class="lead">Descarga tus documentos:</p>
            <a href="desprendible_pago.php" target="_blank" class="btn btn-outline-primary mx-2">
                <i class="bi bi-file-earmark-text"></i> Desprendibles de Pago
            </a>
            <a href="certificado_laboral.php" target="_blank" class="btn btn-outline-success mx-2">
                <i class="bi bi-patch-check"></i> Certificado Laboral
            </a>
        </div>

        <div class="text-center mt-5">
            <h2 class="text-warning">VACACIONES</h2>
            <p class="lead"><strong>Días Totales:</strong> <?php echo $_SESSION['dias_total'] ?> días</p>
            <p class="lead"><strong>Días Disfrutados:</strong> <?php echo $_SESSION['dias_disfrutados'] ?> días</p>
            <h1 class="display-1 text-primary"><?php echo $_SESSION['diferencia_dias']; ?></h1>
            <p class="h4 mb-4">Días pendientes por disfrutar</p>

            <a href="docs/documents/GH.AUS.FO.01.Solicitud.de.Ausentismo.docx" download class="btn btn-outline-warning mb-4">
                <i class="bi bi-file-earmark-arrow-down"></i> Descargar Formato Ausentismo
            </a>

            <form id="formulario" action="cargar_documento.php" method="post" enctype="multipart/form-data" class="border p-4 rounded bg-light">
                <h5 class="mb-3">Subir documento</h5>
                <input class="form-control mb-3" type="file" id="documento" name="documento">
                <button type="submit" class="btn btn-primary"><i class="bi bi-upload"></i> Subir</button>
                <div id="mensaje" class="mt-3" style="display: none;"></div>
            </form>
        </div>

        <div class="text-center mt-5">
            <h2 class="text-danger">¿Está seguro de cerrar sesión?</h2>
            <a href="php/cerrar_sesion.php" class="btn btn-danger mt-3">
                <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
            </a>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#formulario').submit(function (event) {
                event.preventDefault();
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
                        $('#mensaje').html(response).show();
                    },
                    error: function () {
                        $('#mensaje').text('Error al subir el archivo').show();
                    }
                });
            });
        });
    </script>
</body>
</html>