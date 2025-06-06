<?php
session_start();

/* 1. incluye la conexión (ajusta la ruta según tu estructura) */
include '../conexion.php';   // usa $conn

/* 2. valida que lleguen los datos */
if (!isset($_POST['cedula'], $_POST['contrasena'])) {
    exit('❌ Falta cédula o contraseña');
}

$cedula     = $_POST['cedula'];
$contrasena = $_POST['contrasena'];

/* 3. consulta segura */
$sql = "SELECT u.cedula, u.contrasena, u.id_rol AS rol,
               e.nombres, e.apellidos, e.imagen, e.edad, e.eps, e.arl,
               e.correo, e.fecha_ingreso, e.cargo, e.area, e.jefe_inmediato,
               e.caja, e.pensiones, e.cesantias, e.celular,
               v.dias_total, v.dias_disfrutados
        FROM usuarios  u
        JOIN empleados e   ON u.cedula = e.cedula
        LEFT JOIN vacaciones v ON u.cedula = v.cedula
        WHERE u.cedula = ? AND u.contrasena = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $cedula, $contrasena);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    exit('❌ Usuario o contraseña incorrectos');
}

$row = $res->fetch_assoc();

/* 4. llena variables de sesión */
$_SESSION = [
    'rol'             => $row['rol'],
    'usuario'         => $cedula,
    'nombreUsuario'   => $row['nombres'],
    'apellidoUsuario' => $row['apellidos'],
    'imagen'          => $row['imagen'],
    'celular'         => $row['celular'],
    'edad'            => $row['edad'],
    'correo'          => $row['correo'],
    'fecha_ingreso'   => $row['fecha_ingreso'],
    'cargo'           => $row['cargo'],
    'area'            => $row['area'],
    'jefe_inmediato'  => $row['jefe_inmediato'],
    'caja'            => $row['caja'],
    'eps'             => $row['eps'],
    'arl'             => $row['arl'],
    'pensiones'       => $row['pensiones'],
    'cesantias'       => $row['cesantias'],
    'dias_total'      => $row['dias_total'],
    'dias_disfrutados'=> $row['dias_disfrutados'],
    'diferencia_dias' => $row['dias_total'] - $row['dias_disfrutados']
];

/* 5. redirección según rol */
switch ($_SESSION['rol']) {
    case 1: header('Location: ../index_admin.php');  break;
    case 2: header('Location: ../index_usuario.php'); break;
    default: header('Location: ../index_rrhh.php');   break;
}
exit;
?>
