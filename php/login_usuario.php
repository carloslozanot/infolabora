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

$stmt = $conexion->prepare("CALL infolabora.pr_inicial(?)");

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

        if (strtolower($row['estado']) === 'inactivo') {
            echo "<script>alert('El usuario está inactivo. Por favor contacte al administrador.'); window.location.href = '../index.php';</script>";
            exit;
        }

        $_SESSION['permiso'] = $row['permiso'];
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
        $_SESSION['lider_inmediato'] = $row['lider_inmediato'];
        $_SESSION['caja'] = $row['caja'];
        $_SESSION['eps'] = $row['eps'];
        $_SESSION['arl'] = $row['arl'];
        $_SESSION['pensiones'] = $row['pensiones'];
        $_SESSION['cesantias'] = $row['cesantias'];
        $_SESSION['tipo_contrato'] = $row['tipo_contrato'];
        $_SESSION['direccion'] = $row['direccion'];
        $_SESSION['ciudad_residencia'] = $row['ciudad_residencia'];
        $_SESSION['estado'] = $row['estado'];
        $_SESSION['fecha_retiro'] = $row['fecha_retiro'];
        $_SESSION['total_dias_totales'] = $row['total_dias_totales'];
        $_SESSION['total_dias_disfrutados'] = $row['total_dias_disfrutados'];
        $_SESSION['total_dias_dinero'] = $row['total_dias_dinero'];
        $_SESSION['dias_disfrutados'] = $row['total_dias_disfrutados'] + $row['total_dias_dinero'];
        $_SESSION['dias_generados'] = $row['dias_generados'];
        $_SESSION['total_dias_generados'] = $row['dias_generados'] + $row['total_dias_totales'];
        $_SESSION['ultimo_periodo'] = $row['ultimo_periodo'];
        $_SESSION['diferencia_dias'] = $_SESSION['total_dias_generados'] - $row['total_dias_disfrutados'] - $row['total_dias_dinero'];
        $fecha_generacion = date('Y-m-d H:i:s');
        $tipo = 'Ingreso al Sistema';
        $observaciones = 'Inicio de sesión exitoso del usuario: ' . $row['cedula'];

        $result->free();
        $stmt->close();

        $sql_bitacora = "INSERT INTO bitacora (cedula_integrante, fecha_generacion, tipo, observaciones, cargo, contrato, salario, auxilio, total) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $cargo = null;
        $contrato = null;
        $salario = null;
        $auxilio = null;
        $total = null;

        $stmt_bitacora = $conexion->prepare($sql_bitacora);
        $stmt_bitacora->bind_param(
            "sssssssss",
            $row['cedula'],
            $fecha_generacion,
            $tipo,
            $observaciones,
            $cargo,
            $contrato,
            $salario,
            $auxilio,
            $total
        );

        $stmt_bitacora->execute();
        $stmt_bitacora->close();

        if ($_SESSION['permiso'] == 1) {
            header("Location: ../index_admin.php");
        } elseif ($_SESSION['permiso'] == 2) {
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