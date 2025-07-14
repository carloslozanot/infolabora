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

    <link rel="stylesheet" href="docs/css/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <script type="text/javaScript">
        function confirmar() {
            return confirm('¿Esta seguro de realizar esta acción?');            
        }
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
                <div class="option" data-pagina="colaboradores">
                    <i class="bi bi-person-raised-hand" title="Colaboradores"></i>
                    <h4>Colaboradores</h4>
                </div>
            </a>
            <a href="#">
                <div class="option" data-pagina="vacaciones">
                    <i class="bi bi-umbrella" title="Vacaciones"></i>
                    <h4>Vacaciones</h4>
                </div>
            </a>
            <a href="#">
                <div class="option" data-pagina="roles">
                    <i class="bi bi-key" title="Roles"></i>
                    <h4>Roles</h4>
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
            <p style="font-size: 16px;">Agregar y editar usuarios</p>
            <p style="font-size: 16px;">Agregar y editar colaboradores</p>
            <p style="font-size: 16px;">Agregar y editar informacion de vacaciones</p>
            <p style="font-size: 16px;">Agregar y editar roles</p>
        </div>
        <div id="contenido-usuarios" class="contenido" style="display: none;">
            <h2>Lista de Usuarios</h2>
            <br>
            <table class="table table-striped table-bordered table-hover" id="table_id">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Contraseña</th>
                        <th>Fecha Creacion</th>
                        <th>Rol</th>
                    </tr>
                </thead>
                <tbody>

                    <?php

include("php/conexion.php");
                    $SQL = "SELECT * FROM empleados e, usuarios u, roles r WHERE e.cedula = u.cedula and u.id_rol = r.id";
                    $dato = mysqli_query($conexion, $SQL);

                    if ($dato->num_rows > 0) {
                        while ($fila = mysqli_fetch_array($dato)) {
                            ?>
                            <tr>
                                <td>
                                    <?php echo $fila['cedula']; ?>
                                </td>
                                <td>
                                    <?php echo $fila['nombres']; ?>
                                </td>
                                <td>
                                    <?php echo $fila['apellidos']; ?>
                                </td>
                                <td>
                                    <?php echo $fila['contrasena']; ?>
                                </td>
                                <td>
                                    <?php echo $fila['fecha_diligenciamiento']; ?>
                                </td>
                                <td>
                                    <?php echo $fila['descripcion']; ?>
                                </td>

                                <td>
                                    <a class="btn btn-warning" href="editar_usuario.php?id=<?php echo $fila['cedula'] ?> "><i
                                            class="fa-solid fa-pen-to-square"></i>
                                        Editar </a>

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

        <!--COLABORADORES -->
        <div id="contenido-colaboradores" class="contenido" style="display: none;">
            <h2>Lista de Colaboradores</h2>
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
                    $SQL = "SELECT * FROM empleados e";
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
                                    <a class="btn btn-warning"
                                        href="editar_colaborador.php?id=<?php echo $fila['cedula'] ?> "><i
                                            class="fa-solid fa-pen-to-square"></i>
                                        Editar </a> <br>

                                    <a class="btn btn-danger" href="eliminar_colaborador.php?id=<?php echo $fila['cedula'] ?>"
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
                <a class="btn btn-success" href="agregar_colaborador.php"><i class="fa-solid fa-plus"></i> Agregar
                    Colaborador
                </a>
            </div>
        </div>

        <!--VACACIONES -->
        <div id="contenido-vacaciones" class="contenido" style="display: none;">
            <h2>Vacaciones</h2>

            <br>
            <table class="table table-striped table-bordered table-hover" id="table_id">
                <thead>
                    <tr>
                        <th>Cedula</th>
                        <th>Dias totales</th>
                        <th>Dias disfrutados</th>
                    </tr>
                </thead>
                <tbody>

                    <?php

include("php/conexion.php");
                    $SQL_1 = "SELECT * FROM vacaciones";
                    $dato_1 = mysqli_query($conexion, $SQL_1);

                    if ($dato->num_rows > 0) {
                        while ($fila = mysqli_fetch_array($dato_1)) {
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

                                    <a class="btn btn-warning" href="editar_vacaciones.php?id=<?php echo $fila['id'] ?> "><i
                                            class="fa-solid fa-pen-to-square"></i>
                                        Editar </a>

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

        <!--ROLES -->
        <div id="contenido-roles" class="contenido" style="display: none;">
            <h2>Lista de Roles</h2>

            <br>
            <table class="table table-striped table-bordered table-hover" id="table_id">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Descripcion</th>
                    </tr>
                </thead>
                <tbody>

                    <?php

include("php/conexion.php");
                    $SQL_1 = "SELECT * FROM roles ";
                    $dato_1 = mysqli_query($conexion, $SQL_1);

                    if ($dato->num_rows > 0) {
                        while ($fila = mysqli_fetch_array($dato_1)) {
                            ?>
                            <tr>
                                <td>
                                    <?php echo $fila['id']; ?>
                                </td>
                                <td>
                                    <?php echo $fila['descripcion']; ?>
                                </td>
                                <td>

                                    <a class="btn btn-warning" href="editar_rol.php?id=<?php echo $fila['id'] ?> "><i
                                            class="fa-solid fa-pen-to-square"></i>
                                        Editar </a>

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
                <a class="btn btn-success" href="agregar_rol.php"><i class="fa-solid fa-plus"></i> Agregar Rol
                </a>
            </div>
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
    <script>
        function mostrarFormulario() {
            var formulario = document.getElementById("formulario");
            formulario.style.display = "block";
        }
    </script>

</body>

</html>