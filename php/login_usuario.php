<?php
session_start();
include 'php/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cedula = $_POST['cedula'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';

    if ($cedula && $contrasena) {
        $stmt = $conexion->prepare("SELECT cedula, contrasena, id_rol FROM usuarios WHERE cedula = ?");
        $stmt->bind_param("s", $cedula);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            $usuario = $resultado->fetch_assoc();

            if (password_verify($contrasena, $usuario['contrasena'])) {
                $_SESSION['usuario'] = $usuario['cedula'];
                $_SESSION['rol'] = $usuario['id_rol'];

                switch ($_SESSION['rol']) {
                    case 1: header("Location: index_admin.php"); exit;
                    case 2: header("Location: index_usuario.php"); exit;
                    case 3: header("Location: index_rrhh.php"); exit;
                    default: header("Location: index.php?error=Rol%20no%20válido"); exit;
                }
            } else {
                header("Location: index.php?error=Contraseña%20incorrecta");
                exit;
            }
        } else {
            header("Location: index.php?error=Usuario%20no%20encontrado");
            exit;
        }
    } else {
        header("Location: index.php?error=Todos%20los%20campos%20son%20obligatorios");
        exit;
    }
}
?>