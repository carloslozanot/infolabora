<?php
require 'php/conexion.php';

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=integrantes.xls");
header("Pragma: no-cache");
header("Expires: 0");

$consulta = "SELECT * FROM integrantes";
$resultado = mysqli_query($conexion, $consulta);

echo "<table border='1'>";
echo "<tr>
        <th>Estado</th>
        <th>Cédula</th>
        <th>Nombre Completo</th>
        <th>Correo</th>
        <th>Celular</th>
        <th>Cargo</th>
        <th>Fecha Ingreso</th>
      </tr>";

while ($fila = mysqli_fetch_array($resultado)) {
    echo "<tr>";
    echo "<td>" . $fila['estado'] . "</td>";
    echo "<td>" . $fila['cedula'] . "</td>";
    echo "<td>" . $fila['nombres'] . " " . $fila['apellidos'] . "</td>";
    echo "<td>" . $fila['correo'] . "</td>";
    echo "<td>" . $fila['celular'] . "</td>";
    echo "<td>" . $fila['cargo'] . "</td>";
    echo "<td>" . $fila['fecha_ingreso'] . "</td>";
    echo "</tr>";
}

echo "</table>";
?>
