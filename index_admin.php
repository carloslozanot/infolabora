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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="docs/css/estilos.css">

    <script>
        $(document).ready(function () {
            $('#tabla_usuarios').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"
                }
            });

            $('#tabla_integrantes').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"
                }
            });

            $('#tabla_vacaciones').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"
                }
            });

            $('#tabla_permisos').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"
                }
            });
        });
    </script>

</head>

<body id="body">
    <header class="index">
        <div class="icon_menu">
            <i class="bi bi-code" id="btn_open"></i>
        </div>
    </header>

    <div class="menu_side" id="menu_side">
        <div class="name_page">
            <i class="bi bi-person-fill-gear"></i>
            <h4>Administrador</h4>
        </div>
        <div class="options_menu">
            <a href="#">
                <div class="option" data-pagina="inicio">
                    <i class="bi bi-house" title="Inicio"></i>
                    <h4>Inicio</h4>
                </div>
            </a>
            <a href="#">
                <div class="option" data-pagina="usuarios">
                    <i class="bi bi-database" title="Usuarios"></i>
                    <h4>Usuarios</h4>
                </div>
            </a>
            <a href="#">
                <div class="option" data-pagina="integrantes">
                    <i class="bi bi-people-fill" title="Integrantes"></i>
                    <h4>Integrantes</h4>
                </div>
            </a>
            <a href="#">
                <div class="option" data-pagina="vacaciones">
                    <i class="bi bi-umbrella" title="Vacaciones"></i>
                    <h4>Vacaciones</h4>
                </div>
            </a>
            <a href="#">
                <div class="option" data-pagina="permisos">
                    <i class="bi bi-key" title="Permisos"></i>
                    <h4>Permisos</h4>
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
            <p style="font-size: 32px; font-weight:1000;">¡BIENVENIDO, ADMINISTRADOR!<br><br></p>
            <p style="font-size: 20px; font-weight:800;">ESTE ES ES PORTAL ADMINISTRATIVO EN EL CUAL PODRÁ REALIZAR LAS
                SIGUIENTES ACCIONES:<br><br></p>
            <p style="font-size: 16px;"></i>👤 Agregar y editar usuarios</p>
            <p style="font-size: 16px;"></i>👥 Agregar y editar integrantes</p>
            <p style="font-size: 16px;"></i>🌴 Agregar y editar información de vacaciones</p>
            <p style="font-size: 16px;"></i>🔑 Agregar y editar permisos</p>

        </div>
        <div id="contenido-usuarios" class="contenido" style="display: none;">
            <h2>Lista de Usuarios</h2>
            <br>
            <table class="table table-striped table-bordered table-hover" id="tabla_usuarios">
                <thead>
                    <tr>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Usuario</th>
                        <th>Contraseña</th>
                        <th>Permiso</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>

                    <?php

                    include("php/conexion.php");
                    $SQL = "SELECT * FROM integrantes e, usuarios u, permisos r WHERE e.cedula = u.cedula and u.id_permiso = r.id";
                    $dato_usuarios = mysqli_query($conexion, $SQL);

                    if ($dato_usuarios->num_rows > 0) {
                        while ($fila = mysqli_fetch_array($dato_usuarios)) {
                            ?>
                            <tr>
                                <td>
                                    <?php echo $fila['nombres']; ?>
                                </td>
                                <td>
                                    <?php echo $fila['apellidos']; ?>
                                </td>
                                <td>
                                    <?php echo $fila['cedula']; ?>
                                </td>
                                <td>
                                    <?php echo $fila['contrasena']; ?>
                                </td>
                                <td>
                                    <?php echo $fila['descripcion']; ?>
                                </td>

                                <td>
                                    <a class="btn btn-warning me-1 mb-1"
                                        href="editar_usuario.php?id=<?php echo $fila['cedula'] ?>">
                                        <i class="fa-solid fa-pen-to-square"></i> Editar
                                    </a><br>

                                    <a class="btn btn-danger" href="eliminar_usuario.php?id=<?php echo $fila['cedula'] ?>"
                                        onclick='return confirmar()'><i class="fa-solid fa-trash"></i>
                                        Eliminar</a>

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
                <a class="btn btn-success" href="agregar_usuario.php"><i class="fa-solid fa-plus"></i> Agregar Usuario
                </a>
            </div>
        </div>

        <div id="contenido-integrantes" class="contenido" style="display: none;">
            <h2>Lista de Integrantes</h2>
            <br>
            <table class="table table-striped table-bordered table-hover" id="tabla_integrantes">
                <thead>
                    <tr>
                        <th>Estado</th>
                        <th>Cedula</th>
                        <th>Correo</th>
                        <th>Celular</th>
                        <th>Edad</th>
                        <th>Fecha Ingreso</th>
                        <th>Cargo</th>
                        <th>Área</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>

                    <?php

                    include("php/conexion.php");
                    $SQL = "SELECT * FROM integrantes e";
                    $dato_integrantes = mysqli_query($conexion, $SQL);

                    if ($dato_integrantes->num_rows > 0) {
                        while ($fila = mysqli_fetch_array($dato_integrantes)) {
                            ?>
                            <tr>
                                <td>
                                    <?php echo $fila['estado']; ?>
                                </td>
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
                                    <a class="btn btn-warning me-1 mb-1"
                                        href="editar_integrante.php?id=<?php echo $fila['cedula'] ?>">
                                        <i class="fa-solid fa-pen-to-square"></i> Editar
                                    </a><br>

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

        <!--VACACIONES -->
        <div id="contenido-vacaciones" class="contenido" style="display: none;">
            <h2>Vacaciones</h2>

            <br>
            <table class="table table-striped table-bordered table-hover" id="tabla_vacaciones">
                <thead>
                    <tr>
                        <th>Cedula</th>
                        <th>Dias totales</th>
                        <th>Dias disfrutados</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>

                    <?php

                    include("php/conexion.php");
                    $SQL_vacaciones = "SELECT * FROM vacaciones";
                    $dato_vacaciones = mysqli_query($conexion, $SQL_vacaciones);

                    if ($dato_vacaciones->num_rows > 0) {
                        while ($fila = mysqli_fetch_array($dato_vacaciones)) {
                            ?>
                            <tr>
                                <td>
                                    <?php echo $fila['cedula']; ?>
                                </td>
                                <td>
                                    <?php echo $fila['dias_total']; ?>
                                </td>
                                <td>
                                    <?php echo $fila['dias_disfrutados']; ?>
                                </td>
                                <td>

                                    <a class="btn btn-warning me-1 mb-1"
                                        href="editar_vacaciones.php?id=<?php echo $fila['cedula'] ?>">
                                        <i class="fa-solid fa-pen-to-square"></i> Editar
                                    </a><br>

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
                <a class="btn btn-success" href="agregar_vacaciones.php"><i class="fa-solid fa-plus"></i> Agregar
                    Vacaciones
                </a>
            </div>
        </div>

        <div id="contenido-permisos" class="contenido" style="display: none;">
            <h2>Lista de Permisos</h2>

            <br>
            <table class="table table-striped table-bordered table-hover" id="tabla_permisos">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Descripcion</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>

                    <?php

                    include("php/conexion.php");
                    $SQL_permisos = "SELECT * FROM permisos";
                    $dato_permisos = mysqli_query($conexion, $SQL_permisos);

                    if ($dato_permisos->num_rows > 0) {
                        while ($fila = mysqli_fetch_array($dato_permisos)) {
                            ?>
                            <tr>
                                <td>
                                    <?php echo $fila['id']; ?>
                                </td>
                                <td>
                                    <?php echo $fila['descripcion']; ?>
                                </td>
                                <td>

                                    <a class="btn btn-warning me-1 mb-1" href="editar_permiso.php?id=<?php echo $fila['id'] ?>">
                                        <i class="fa-solid fa-pen-to-square"></i> Editar
                                    </a><br>

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
                <a class="btn btn-success" href="agregar_permiso.php"><i class="fa-solid fa-plus"></i> Agregar Permiso
                </a>
            </div>
        </div>



        <div id="contenido-cerrar-sesion" class="contenido" style="display: none;">
            <br>
            <label style="display: block; text-align: center;font-weight: 700; font-size: 40px">¿Esta seguro de cerrar
                sesion?</label><br>
            <a href="php/cerrar_sesion.php" class="btn btn-danger"><i class="fa-solid fa-right-from-bracket"></i> CERRAR
                SESION</a>
        </div>
    </main>

    <!-- Incluye el archivo JavaScript -->
    <script src="docs/js/script.js"></script>
    <script>
        function mostrarFormulario() {
            var formulario = document.getElementById("formulario");
            formulario.style.display = "block";
        }
    </script>

</body>

</html>