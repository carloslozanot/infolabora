<?php
session_start();

include '/conexion.php'; // Asegúrate que la ruta sea correcta

// Mostrar errores
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!isset($_POST['cedula'], $_POST['contrasena'])) {
    die("❌ Faltan datos del formulario.");
}

$cedula = mysqli_real_escape_string($conn, $_POST['cedula']);
$contrasena = mysqli_real_escape_string($conn, $_POST['contrasena']);

$validar_login = mysqli_query($conn, "
    SELECT usuarios.cedula, usuarios.contrasena, usuarios.id_rol AS rol,
           empleados.nombres, empleados.apellidos, empleados.imagen, empleados.edad,
           empleados.eps, empleados.arl, empleados.correo, empleados.fecha_ingreso,
           empleados.cargo, empleados.area, empleados.jefe_inmediato, empleados.caja,
           empleados.pensiones, empleados.cesantias, empleados.celular,
           vacaciones.dias_total, vacaciones.dias_disfrutados
    FROM usuarios
    INNER JOIN empleados ON usuarios.cedula = empleados.cedula
    LEFT JOIN vacaciones ON usuarios.cedula = vacaciones.cedula
    WHERE usuarios.cedula='$cedula' AND usuarios.contrasena = '$contrasena'
");

if (!$validar_login) {
    die("❌ Error en la consulta: " . mysqli_error($conn));
}

if (mysqli_num_rows($validar_login) > 0) {
    $row = mysqli_fetch_assoc($validar_login);
    
    $_SESSION['rol'] = $row['rol'];
    $_SESSION['usuario'] = $cedula;
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

    if ($_SESSION['rol'] == 1) {
        header("Location: ../index_admin.php");
    } elseif ($_SESSION['rol'] == 2) {
        header("Location: ../index_usuario.php");
    } else {
        header("Location: ../index_rrhh.php");
    }
    exit;
} else {
    echo "❌ Usuario o contraseña incorrectos";
    exit;
}

mysqli_close($conn);
?>
