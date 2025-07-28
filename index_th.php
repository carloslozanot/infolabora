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
                <div class="option" data-pagina="bitacora"><i class="bi bi-journal-text"></i>
                    <h4>Bitácora</h4>
                </div>
            </a>
            <a href="#">
                <div class="option" data-pagina="th-vacaciones"><i class="bi bi-umbrella"></i>
                    <h4>Vacaciones</h4>
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
            <div class="row justify-content-center text-center seccion-cerrar-sesion">
                <div class="col-md-12">
                    <p style="font-size: 32px; font-weight:1000;">¡Bienvenido,
                        <?php echo $_SESSION['nombreUsuario'] . ' ' . $_SESSION['apellidoUsuario'] . '!'; ?><br><br>
                    </p>
                    <p style="font-size: 20px; font-weight:800;">
                        Este es el portal de Talento Humano en el cual podrá realizar las siguientes acciones:<br><br>
                    </p>
                    <p style="font-size: 16px;">🔍 Consultar los datos de los integrantes de la compañia</p>
                    <p style="font-size: 16px;">📋 Consultar y descargar bitacora</p>
                    <p style="font-size: 16px;">📎 Descargar referencias laborales</p>
                    <p style="font-size: 16px;">🌴 Autorizar o rechazar solicitudes de vacaciones</p>
                </div>
            </div>
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

                                    <?php if ($fila['estado'] === 'Activo') { ?>
                                        <a class="btn btn-danger mt-1"
                                            href="desactivar_integrante.php?id=<?php echo $fila['cedula'] ?>"
                                            onclick='return confirmar()'>
                                            <i class="fa-solid fa-ban"></i> Desactivar
                                        </a>
                                    <?php } else { ?>
                                        <a class="btn btn-primary mt-1"
                                            href="activar_integrante.php?id=<?php echo $fila['cedula'] ?>"
                                            onclick='return confirmar()'>
                                            <i class="fa-solid fa-check-circle"></i> Activar
                                        </a><br>

                                        <a class="btn btn-dark mt-1"
                                            href="fpdf/referencia.php?cedula=<?php echo $fila['cedula']; ?>" target="_blank">
                                            <i class="fa-solid fa-file-lines"></i> Generar referencia
                                        </a>
                                    <?php } ?>
                                </td>

                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
            <br>
            <div class="d-flex justify-content-between mb-3">
                <a class="btn btn-success" href="agregar_integrante.php">
                    <i class="fa-solid fa-plus"></i> Agregar Integrante
                </a>

                <a class="btn btn-info" href="exportar_excel.php" target="_blank">
                    <i class="fa-solid fa-file-excel"></i> Exportar a excel
                </a>
            </div>
        </div>

        <div id="contenido-bitacora" class="contenido" style="display: none;">
            <div class="tarjeta-certificados">
                <div class="texto-certificados">
                    <h2 class="font-weight-bold" style="font-size: 36px; color:#150940;">BITÁCORA</h2>
                </div>
                <?php
                include("php/conexion.php");
                $sql = "SELECT COUNT(*) AS total_ingresos FROM bitacora WHERE tipo = 'Ingreso al Sistema'";
                $resultado = mysqli_query($conexion, $sql);
                $fila = mysqli_fetch_assoc($resultado);
                $total_ingresos = $fila['total_ingresos'];
                $sql_certificados = "SELECT COUNT(*) AS total_certificados FROM bitacora WHERE tipo = 'Certificado Laboral'";
                $resultado_certificados = mysqli_query($conexion, $sql_certificados);
                $fila_certificados = mysqli_fetch_assoc($resultado_certificados);
                $total_certificados = $fila_certificados['total_certificados'];
                $sql_integrantes = "select CONCAT(nombres, ' ', apellidos) AS nombre_completo, COUNT(*) AS total_ingreso
            from bitacora b, integrantes i
            where b.cedula_empleado = i.cedula
            and tipo = 'Ingreso al Sistema'
            and cedula_empleado not in (100, 123)
            group by nombre_completo
            order by total_ingreso desc
            limit 5";
                $resultado_integrantes = mysqli_query($conexion, $sql_integrantes);
                $fila_integrantes = mysqli_fetch_assoc($resultado_integrantes);
                $total_nombre = $fila_integrantes['nombre_completo'];
                $total_cantidad = $fila_integrantes['total_ingreso'];
                $sql_cert_laboral = "select CONCAT(nombres, ' ', apellidos) AS nombre_completo, COUNT(*) AS total_ingreso
            from bitacora b, integrantes i
            where b.cedula_empleado = i.cedula
            and tipo = 'Certificado Laboral'
            and cedula_empleado not in (100, 123)
            group by nombre_completo
            order by total_ingreso desc
            limit 5";
                $resultado_cert_laboral = mysqli_query($conexion, $sql_cert_laboral);
                $fila_cert_laboral = mysqli_fetch_assoc($resultado_cert_laboral);
                $total_nombres = $fila_integrantes['nombre_completo'];
                $total_cantidades = $fila_integrantes['total_ingreso'];
                $sql_desprendible = "select CONCAT(nombres, ' ', apellidos) AS nombre_completo, COUNT(*) AS total_ingreso
            from bitacora b, integrantes i
            where b.cedula_empleado = i.cedula
            and tipo = 'Desprendible de Pago'
            and cedula_empleado not in (100, 123)
            group by nombre_completo
            order by total_ingreso desc
            limit 5";
                $resultado_desprendible = mysqli_query($conexion, $sql_desprendible);
                $fila_desprendible = mysqli_fetch_assoc($resultado_desprendible);
                $nombres_desprendible = $fila_desprendible['nombre_completo'];
                $ingreso_desprendible = $fila_desprendible['total_ingreso'];
                ?>

                <div class="row justify-content-center">
                    <div class="col-md-5 mb-4">
                        <div class="card card-hover shadow-lg border-0 text-center">
                            <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                <div class="mb-2">
                                    <i class="bi bi-person-check-fill icono-card"></i>
                                </div>
                                <h5 class="card-title mb-1">Ingresos al sistema</h5>
                                <h3 class="mb-0 cantidad-card"><?php echo $total_ingresos; ?></h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-10 mb-4">
                        <div class="card card-hover shadow-lg border-0 text-center">
                            <div class="card-body">
                                <div class="mb-3">
                                    <i class="bi bi-people-fill icono-card"></i>
                                </div>
                                <h5 class="card-title mb-3">Top ingresos al sistema</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>#</th>
                                                <th>Nombre Completo</th>
                                                <th>Total Ingresos</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $contador = 1;
                                            mysqli_data_seek($resultado_integrantes, 0);
                                            while ($fila = mysqli_fetch_assoc($resultado_integrantes)) {
                                                echo "<tr>";
                                                echo "<td>{$contador}</td>";
                                                echo "<td>{$fila['nombre_completo']}</td>";
                                                echo "<td>{$fila['total_ingreso']}</td>";
                                                echo "</tr>";
                                                $contador++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5 mb-4">
                        <div class="card card-hover shadow-lg border-0 text-center">
                            <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                <div class="mb-2">
                                    <i class="bi bi-file-earmark-check-fill icono-card"></i>
                                </div>
                                <h5 class="card-title mb-1">Certificados laborales generados</h5>
                                <h3 class="mb-0 cantidad-card"><?php echo $total_certificados; ?></h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-10 mb-4">
                        <div class="card card-hover shadow-lg border-0 text-center">
                            <div class="card-body">
                                <div class="mb-3">
                                    <i class="bi bi-people-fill icono-card"></i>
                                </div>
                                <h5 class="card-title mb-3">Top Certificados laborales generados</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>#</th>
                                                <th>Nombre Completo</th>
                                                <th>Total Ingresos</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $contador = 1;
                                            mysqli_data_seek($resultado_cert_laboral, 0); // Asegura que se reinicie el puntero del resultado
                                            while ($fila = mysqli_fetch_assoc($resultado_cert_laboral)) {
                                                echo "<tr>";
                                                echo "<td>{$contador}</td>";
                                                echo "<td>{$fila['nombre_completo']}</td>";
                                                echo "<td>{$fila['total_ingreso']}</td>";
                                                echo "</tr>";
                                                $contador++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5 mb-4">
                        <div class="card card-hover shadow-lg border-0 text-center">
                            <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                <div class="mb-2">
                                    <i class="bi bi-file-earmark-check-fill icono-card"></i>
                                </div>
                                <h5 class="card-title mb-1">Desprendibles de Pago generados</h5>
                                <h3 class="mb-0 cantidad-card"><?php echo $ingreso_desprendible; ?></h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-10 mb-4">
                        <div class="card card-hover shadow-lg border-0 text-center">
                            <div class="card-body">
                                <div class="mb-3">
                                    <i class="bi bi-people-fill icono-card"></i>
                                </div>
                                <h5 class="card-title mb-3">Top Desprendibles de Pago generados</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>#</th>
                                                <th>Nombre Completo</th>
                                                <th>Total Ingresos</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $contador = 1;
                                            mysqli_data_seek($resultado_desprendible, 0); // Asegura que se reinicie el puntero del resultado
                                            while ($fila = mysqli_fetch_assoc($resultado_desprendible)) {
                                                echo "<tr>";
                                                echo "<td>{$contador}</td>";
                                                echo "<td>{$fila['nombre_completo']}</td>";
                                                echo "<td>{$fila['total_ingreso']}</td>";
                                                echo "</tr>";
                                                $contador++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <a class="btn btn-info" href="exportar_excel.php" target="_blank">
                    <i class="fa-solid fa-file-excel"></i> Exportar a Excel
                </a>
            </div>
        </div>

        <div id="contenido-th-vacaciones" class="contenido" style="display: none;">
            <h2 class="text-center mb-4">Historial de Solicitudes de Vacaciones</h2>
            <table class="table table-bordered table-hover" id="tabla_historial_vacaciones">
                <thead class="table-dark">
                    <tr>
                        <th>Radicado</th>
                        <th>Nombre completo</th>
                        <th>Fecha Diligencia</th>
                        <th>Periodo</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Reintegro</th>
                        <th>Días</th>
                        <th>Dinero</th>
                        <th>Estado</th>
                        <th>Comentario</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql_vacaciones = "SELECT * FROM solicitudes ORDER BY fecha_diligenciamiento DESC";
                    $res_vacaciones = mysqli_query($conexion, $sql_vacaciones);
                    while ($row = mysqli_fetch_assoc($res_vacaciones)) {
                        echo "<tr>
        <td>{$row['radicado']}</td>
        <td>{$row['nombre_completo']}</td>
        <td>{$row['fecha_diligenciamiento']}</td>
        <td>{$row['periodo']}</td>
        <td>{$row['fecha_inicio']}</td>
        <td>{$row['fecha_reintegro']}</td>
        <td>{$row['dias']}</td>
        <td>{$row['dinero']}</td>
        <td>";

                        $estado = $row['estado'];
                        if ($estado === 'Solicitadas') {
                            echo "<span class='badge bg-secondary'>{$estado}</span>";
                        } elseif ($estado === 'Aprobadas') {
                            echo "<span class='badge bg-success'>{$estado}</span>";
                        } elseif ($estado === 'Rechazadas') {
                            echo "<span class='badge bg-danger'>{$estado}</span>";
                        } else {
                            echo "<span class='badge bg-light text-dark'>{$estado}</span>";
                        }

                        echo "</td>
        <td>{$row['comentarios']}</td>
        <td>";

                        if ($row['estado'] === 'Solicitadas') {
                            echo "
        <a href='editar_sol_vacaciones.php?id={$row['radicado']}&accion=aprobar' 
           class='btn btn-success btn-sm mb-1'
           onclick=\"return confirm('¿Estás seguro de aprobar esta solicitud?')\">
            <i class='fas fa-check'></i> Aprobar
        </a><br>
        <a href='editar_sol_vacaciones.php?id={$row['radicado']}&accion=rechazar' 
           class='btn btn-danger btn-sm'
           onclick=\"return confirm('¿Estás seguro de rechazar esta solicitud?')\">
            <i class='fas fa-times'></i> Rechazar
        </a>";
                        } else {
                            echo "<span class='text-muted'>Finalizada</span>";
                        }

                        echo "</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <?php if (isset($_GET['mensaje']) && $_GET['mensaje'] === 'ok'): ?>
            <script>
                window.onload = function () {
                    alert('Solicitud procesada exitosamente.');
                };
            </script>
        <?php endif; ?>

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

    <script>
        $(document).ready(function () {
            const opciones = {
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
            };

            $('#tabla_integrantes').DataTable(opciones);
            $('#tabla_historial_vacaciones').DataTable(opciones);
        });
    </script>

    <!-- Otros scripts de tu sistema -->
    <script src="docs/js/script.js"></script>
</body>

</html>