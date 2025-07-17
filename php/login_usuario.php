<?php
session_start();
date_default_timezone_set('America/Bogota'); 
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
    integrantes.nombres, integrantes.apellidos, integrantes.imagen,
    integrantes.edad, integrantes.eps, integrantes.arl, integrantes.correo, integrantes.fecha_ingreso,
    integrantes.cargo, integrantes.area, integrantes.jefe_inmediato, integrantes.caja, integrantes.pensiones,
    integrantes.cesantias, integrantes.celular, info_integrantes.tipo_contrato,
    vacaciones.dias_total, vacaciones.dias_disfrutados
FROM usuarios 
INNER JOIN integrantes ON usuarios.cedula = integrantes.cedula
LEFT OUTER JOIN info_integrantes ON usuarios.cedula = info_integrantes.cedula
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
        $fecha_generacion = date('Y-m-d H:i:s');
        $tipo = 'Ingreso al Sistema';
        $observaciones = 'Inicio de sesión exitoso del usuario:' . $row['cedula'];

        // Insertar en bitácora
        $sql_bitacora = "INSERT INTO bitacora (cedula_empleado, fecha_generacion, tipo, observaciones) VALUES (?, ?, ?, ?)";
        $stmt_bitacora = $conexion->prepare($sql_bitacora);
        $stmt_bitacora->bind_param("ssss", $row['cedula'], $fecha_generacion, $tipo, $observaciones);
        $stmt_bitacora->execute();
        $stmt_bitacora->close();


        if ($_SESSION['rol'] == 1) {
            header("Location: ../index_admin.php");
        } elseif ($_SESSION['rol'] == 2) {
            header("Location: ../index_integrante.php");
        } else {
            header("Location: ../index_th.php");
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