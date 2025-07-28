<?php
require 'php/conexion.php';

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=bitacora.xlsx");
header("Pragma: no-cache");
header("Expires: 0");

$consulta = "SELECT * FROM bitacora";
$resultado = mysqli_query($conexion, $consulta);

echo "<table border='1'>";
echo "<tr>
        <th>Cédula</th>
        <th>Fecha Generación</th>
        <th>Tipo</th>
        <th>Observaciones</th>
        
      </tr>";

while ($fila = mysqli_fetch_array($resultado)) {
    echo "<tr>";
    echo "<td>" . $fila['cedula_integrante'] . "</td>";
    echo "<td>" . $fila['fecha_generacion'] . "</td>";
    echo "<td>" . $fila['tipo'] . "</td>";
    echo "<td>" . $fila['observaciones'] . "</td>";
    echo "</tr>";
}

echo "</table>";
?>
