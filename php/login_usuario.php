<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'conexion.php';  // Importante que use la variable $conexion definida ahí

// Obtener datos POST
$cedula = $_POST['cedula'] ?? '';
$contrasena = $_POST['contrasena'] ?? '';

// Validar que se enviaron datos
if (!$cedula || !$contrasena) {
    die("Error: faltan datos de login.");
}

// Evitar inyección SQL con consultas preparadas
$stmt = $conexion->prepare("SELECT 
    usuarios.cedula, usuarios.contrasena, usuarios.id_rol as rol, 
    empleados.nombres, empleados.apellidos, empleados.imagen,
    empleados.edad, empleados.eps, empleados.arl, empleados.correo, empleados.fecha_ingreso,
    empleados.cargo, empleados.area, empleados.jefe_inmediato, empleados.caja, empleados.pensiones,
    empleados.cesantias, empleados.celular,
    vacaciones.dias_total, vacaciones.dias_disfrutados
FROM usuarios 
INNER JOIN empleados ON usuarios.cedula = empleados.cedula
LEFT OUTER JOIN vacaciones ON usuarios.cedula = vacaciones.cedula
WHERE usuarios.cedula = ? AND usuarios.contrasena = ?");

if (!$stmt) {
    die("Error en la consulta: " . $conexion->error);
}

$stmt->bind_param('ss', $cedula, $contrasena);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Guardar datos en sesión
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

    // Redireccionar según rol
    if ($_SESSION['rol'] == 1) {
        header("Location: ../index_admin.php");
        exit;
    } elseif ($_SESSION['rol'] == 2) {
        header("Location: ../index_usuario.php");
        exit;
    } else {
        header("Location: ../index_rrhh.php");
        exit;
    }

} else {
    echo "Usuario o contraseña incorrectos.";
}

$stmt->close();
$conexion->close();
?>
