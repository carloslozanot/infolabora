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

$sql = "SELECT nombre_vacante FROM vacantes";
$result = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Talento Humano</title>

    <!-- Fuentes y Estilos -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="docs/css/estilos.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
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
                <div class="option" data-pagina="inicio"><i class="bi bi-house-door"></i>
                    <h4>Inicio</h4>
                </div>
            </a>
            <a href="#">
                <div class="option" data-pagina="integrantes"><i class="bi bi-people-fill"></i>
                    <h4>Integrantes</h4>
                </div>
            </a>
            <a href="#">
                <div class="option" data-pagina="bitacora"><i class="bi bi-download"></i>
                    <h4>Bitacora</h4>
                </div>
            </a>
            <a href="#">
                <div class="option" data-pagina="cerrar-sesion"><i class="bi bi-box-arrow-right"></i>
                    <h4>Cerrar Sesión</h4>
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
            <h2>Lista de Integrantes</h2><br>
            <table class="table table-striped table-bordered table-hover" id="tabla_integrantes">
                <thead>
                    <tr>
                        <th>Estado</th>
                        <th>Cédula</th>
                        <th>Nombre Completo</th>
                        <th>Correo</th>
                        <th>Celular</th>
                        <th>Cargo</th>
                        <th>Fecha Ingreso</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $SQL = "SELECT * FROM integrantes";
                    $dato = mysqli_query($conexion, $SQL);
                    if ($dato->num_rows > 0) {
                        while ($fila = mysqli_fetch_array($dato)) {
                            ?>
                            <tr>
                                <td>
                                    <?php if ($fila['estado'] === 'Activo') { ?>
                                        <span class="btn btn-success btn-sm disabled">Activo</span>
                                    <?php } else { ?>
                                        <span class="btn btn-danger btn-sm disabled">Inactivo</span>
                                    <?php } ?>
                                </td>
                                <td><?php echo $fila['cedula']; ?></td>
                                <td><?php echo $fila['nombres'] . ' ' . $fila['apellidos']; ?></td>
                                <td><?php echo $fila['correo']; ?></td>
                                <td><?php echo $fila['celular']; ?></td>
                                <td><?php echo $fila['cargo']; ?></td>
                                <td><?php echo $fila['fecha_ingreso']; ?></td>
                                <td>
                                    <a class="btn btn-warning me-1 mb-1"
                                        href="editar_integrante.php?id=<?php echo $fila['cedula'] ?>">
                                        <i class="fa-solid fa-pen-to-square"></i> Editar
                                    </a><br>
                                    <a class="btn btn-primary mt-1"
                                        href="deshabilitar_integrante.php?id=<?php echo $fila['cedula'] ?>"
                                        onclick='return confirmar()'>
                                        <i class="fa-solid fa-ban"></i> Deshabilitar
                                    </a>
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
                    Integrante</a>
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
            <label style="display: block; text-align: center;font-weight: bold; font-size: 40px">¿Está seguro de cerrar
                sesión?</label><br>
            <a href="php/cerrar_sesion.php" class="btn btn-danger"><i class="fa-solid fa-right-from-bracket"></i> CERRAR
                SESIÓN</a>
        </div>
    </main>

    <script>
        $(document).ready(function () {
            $('#tabla_integrantes').DataTable({
                language: {
                    search: "Buscar:",
                    lengthMenu: "Mostrar _MENU_ registros",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    paginate: {
                        first: "Primero",
                        last: "Último",
                        next: "Siguiente",
                        previous: "Anterior"
                    },
                    zeroRecords: "No se encontraron resultados",
                    infoEmpty: "Mostrando 0 a 0 de 0 registros",
                    infoFiltered: "(filtrado de _MAX_ registros totales)"
                }
            });
        });
    </script>

    <!-- Otros scripts de tu sistema -->
    <script src="docs/js/script.js"></script>
</body>

</html>