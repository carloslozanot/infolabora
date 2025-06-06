<?php

session_start();

include 'conexion.php';

$cedula = $_POST['cedula'];
$contrasena = $_POST['contrasena'];


$validar_login = mysqli_query($conn, "SELECT usuarios.cedula as cedula, usuarios.contrasena as contrasena, usuarios.id_rol as rol, empleados.nombres as nombres, empleados.apellidos as apellidos, empleados.imagen as imagen,
    empleados.edad as edad, empleados.eps as eps, empleados.arl as arl, empleados.correo as correo, empleados.fecha_ingreso as fecha_ingreso, empleados.cargo as cargo, empleados.area as area, empleados.jefe_inmediato as jefe_inmediato,
    empleados.caja as caja, empleados.pensiones as pensiones, empleados.cesantias as cesantias, empleados.celular as celular, vacaciones.dias_total as dias_total, vacaciones.dias_disfrutados as dias_disfrutados
    FROM usuarios 
    INNER JOIN empleados ON usuarios.cedula = empleados.cedula
    LEFT OUTER JOIN vacaciones ON usuarios.cedula = vacaciones.cedula
    WHERE usuarios.cedula='$cedula' and usuarios.contrasena = '$contrasena'");

print_r($validar_login);

if (mysqli_num_rows($validar_login) > 0) {
    $row = mysqli_fetch_assoc($validar_login);
    $rol = $row['rol'];
    print_r($_rol);
    $nombreUsuario = $row['nombres'];
    $apellidosUsuario = $row['apellidos'];
    $imagen = $row['imagen'];
    $celular = $row['celular'];
    $edad = $row['edad'];
    $correo = $row['correo'];
    $fecha_ingreso = $row['fecha_ingreso'];
    $cargo = $row['cargo'];
    $area = $row['area'];
    $jefe_inmediato = $row['jefe_inmediato'];
    $caja = $row['caja'];
    $eps = $row['eps'];
    $arl = $row['arl'];
    $pensiones = $row['pensiones'];
    $cesantias = $row['cesantias'];
    $dias_total = $row['dias_total'];
    $dias_disfrutados = $row['dias_disfrutados'];
    $diferencia_dias = $row['dias_total'] - $row['dias_disfrutados'];
    //Iniciar sesión y redirigir a la página principal
    $_SESSION['rol'] = $rol;
    $_SESSION['usuario'] = $cedula;
    $_SESSION['nombreUsuario'] = $nombreUsuario;
    $_SESSION['apellidoUsuario'] = $apellidosUsuario;
    $_SESSION['imagen'] = $imagen;
    $_SESSION['celular'] = $celular;
    $_SESSION['edad'] = $edad;
    $_SESSION['correo'] = $correo;
    $_SESSION['fecha_ingreso'] = $fecha_ingreso;
    $_SESSION['cargo'] = $cargo;
    $_SESSION['area'] = $area;
    $_SESSION['jefe_inmediato'] = $jefe_inmediato;
    $_SESSION['caja'] = $caja;
    $_SESSION['eps'] = $eps;
    $_SESSION['arl'] = $arl;
    $_SESSION['pensiones'] = $pensiones;
    $_SESSION['cesantias'] = $cesantias;
    $_SESSION['dias_total'] = $dias_total;
    $_SESSION['dias_disfrutados'] = $dias_disfrutados;
    $_SESSION['diferencia_dias'] = $diferencia_dias;


    if ($_SESSION['rol'] == 1) {
        header("location:../index_admin.php");
        exit;
    } else if ($_SESSION['rol'] == 2) {
        header("location:../index_usuario.php");
    } else {
        header("location:../index_rrhh.php");
    }
} else {
   
    exit;
}

mysqli_close($conn);


?>