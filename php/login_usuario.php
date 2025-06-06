<?php
session_start();

include 'conexion.php';

// Verificar conexión
if (!$conexion) {
    die("Error en la conexión a la base de datos: " . mysqli_connect_error());
}

// Escapar inputs
$cedula = mysqli_real_escape_string($conexion, $_POST['cedula'] ?? '');
$contrasena = mysqli_real_escape_string($conexion, $_POST['contrasena'] ?? '');

// Validar que no estén vacíos
if (empty($cedula) || empty($contrasena)) {
    die("Por favor complete ambos campos.");
}

// Consulta segura
$query = "SELECT usuarios.cedula as cedula, usuarios.contrasena as contrasena, usuarios.id_rol as rol,
    empleados.nombres as nombres, empleados.apellidos as apellidos, empleados.imagen as imagen,
    empleados.edad as edad, empleados.eps as eps, empleados.arl as arl, empleados.correo as correo,
    empleados.fecha_ingreso as fecha_ingreso, empleados.cargo as cargo, empleados.area as area,
    empleados.jefe_inmediato as jefe_inmediato, empleados.caja as caja, empleados.pensiones as pensiones,
    empleados.cesantias as cesantias, empleados.celular as celular, vacaciones.dias_total as dias_total,
    vacaciones.dias_disfrutados as dias_disfrutados
FROM usuarios
INNER JOIN empleados ON usuarios.cedula = empleados.cedula
LEFT JOIN vacaciones ON usuarios.cedula = vacaciones.cedula
WHERE usuarios.cedula='$cedula' AND usuarios.contrasena='$contrasena'";

$validar_login = mysqli_query($conexion, $query);

if (!$validar_login) {
    die("Error en consulta SQL: " . mysqli_error($conexion));
}

if (mysqli_num_rows($validar_login) > 0) {
    $row = mysqli_fetch_assoc($validar_login);

    // Asignar variables de sesión
    $_SESSION['rol'] = $row['rol'];
    $_SESSION['usuario'] = $row['cedula'];
    $_SESSION['nombreUsuario'] = $row['nombres'];
    $_SESSION['apellidoUsuario'] = $row['apellidos'];
    $_SESSION['imagen'] = $row['imagen'];
    $_SESSION['celular'] = $row['celular'];
    $_SESSION['edad'] = $row['edad'];
    $_SESSION['correo'] = $row['correo'];
    $_SESSION['fecha_ingreso'] = $row['fecha_ingreso'];
    $_SESSION['cargo'] = $row['cargo'];
    $_SESSION['area'] = $row['area'];
    $_SESSION['jefe_inmediato'] = $row['jefe_inmediato'];
    $_SESSION['caja'] = $row['caja'];
    $_SESSION['eps'] = $row['eps'];
    $_SESSION['arl'] = $row['arl'];
    $_SESSION['pensiones'] = $row['pensiones'];
    $_SESSION['cesantias'] = $row['cesantias'];
    $_SESSION['dias_total'] = $row['dias_total'];
    $_SESSION['dias_disfrutados'] = $row['dias_disfrutados'];
    $_SESSION['diferencia_dias'] = $row['dias_total'] - $row['dias_disfrutados'];

    // Redirigir según rol
    if ($_SESSION['rol'] == 1) {
        header("Location: ../index_admin.php");
        exit();
    } else if ($_SESSION['rol'] == 2) {
        header("Location: ../index_usuario.php");
        exit();
    } else {
        header("Location: ../index_rrhh.php");
        exit();
    }
} else {
    // Usuario no encontrado o credenciales incorrectas
    echo "Credenciales incorrectas. Intente de nuevo.";
}

mysqli_close($conexion);
?>
