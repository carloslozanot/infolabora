<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'conexion.php';

$cedula = $_POST['cedula'] ?? '';
$contrasena = $_POST['contrasena'] ?? '';

if (!$cedula || !$contrasena) {
    echo "<script>alert('Faltan datos de login.'); window.location.href = '../index.php';</script>";
    exit;
}

$stmt = $conexion->prepare("SELECT 
    usuarios.cedula, usuarios.contrasena, usuarios.id_rol as rol, 
    empleados.nombres, empleados.apellidos, empleados.imagen,
    empleados.edad, empleados.eps, empleados.arl, empleados.correo, empleados.fecha_ingreso,
    empleados.cargo, empleados.area, empleados.jefe_inmediato, empleados.caja, empleados.pensiones,
    empleados.cesantias, empleados.celular, info_empleados.tipo_contrato,
    vacaciones.dias_total, vacaciones.dias_disfrutados
FROM usuarios 
INNER JOIN empleados ON usuarios.cedula = empleados.cedula
INNER JOIN info_empleados ON usuarios.cedula = info_empleados.cedula
LEFT OUTER JOIN vacaciones ON usuarios.cedula = vacaciones.cedula
WHERE usuarios.cedula = ?");

if (!$stmt) {
    echo "<script>alert('Error en la consulta.'); window.location.href = '../index.php';</script>";
    exit;
}

$stmt->bind_param('s', $cedula);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    if (password_verify($contrasena, $row['contrasena'])) {
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
        $_SESSION['tipo_contrato'] = $row['tipo_contrato'];
        $_SESSION['dias_total'] = $row['dias_total'];
        $_SESSION['dias_disfrutados'] = $row['dias_disfrutados'];
        $_SESSION['diferencia_dias'] = $row['dias_total'] - $row['dias_disfrutados'];

        if ($_SESSION['rol'] == 1) {
            header("Location: ../index_admin.php");
        } elseif ($_SESSION['rol'] == 2) {
            header("Location: ../index_integrante.php");
        } else {
            header("Location: ../index_rrhh.php");
        }
        exit;

    } else {
        echo "<script>alert('Contraseña incorrecta.'); window.location.href = '../index.php';</script>";
        exit;
    }

} else {
    echo "<script>alert('Usuario no encontrado.'); window.location.href = '../index.php';</script>";
    exit;
}

$stmt->close();
$conexion->close();
?>
