<?php
include("php/conexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? null;
    $cedulas = $_POST['cedulas'] ?? [];

    if (!in_array($accion, ['activar', 'desactivar']) || empty($cedulas)) {
        http_response_code(400);
        echo "Acción inválida o sin cédulas seleccionadas.";
        exit;
    }

    // Determinar el nuevo estado
    $nuevoEstado = $accion === 'activar' ? 'Activo' : 'Inactivo';

    // Preparar los valores para SQL
    $cedulasEscapadas = array_map('intval', $cedulas); // Seguridad básica
    $listaCedulas = implode(',', $cedulasEscapadas);

    // Ejecutar actualización
    $SQL = "UPDATE integrantes SET estado = '$nuevoEstado' WHERE cedula IN ($listaCedulas)";
    if (mysqli_query($conexion, $SQL)) {
        echo "Estado actualizado correctamente para " . count($cedulas) . " integrante(s).";
    } else {
        http_response_code(500);
        echo "Error al actualizar los estados: " . mysqli_error($conexion);
    }
}
?>
