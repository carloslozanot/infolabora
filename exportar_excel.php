<?php
require 'php/conexion.php';

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Integrantes.xls");
header("Pragma: no-cache");
header("Expires: 0");

$consulta = "SELECT * FROM integrantes";
$resultado = mysqli_query($conexion, $consulta);

echo "<table border='1'>";
echo "<tr>
        <th>Estado</th>
        <th>Cédula</th>
        <th>Nombre Completo</th>
        <th>Edad</th>
        <th>Celular</th>
        <th>Correo</th>
        <th>Dirección</th> 
        <th>Ciudad Residencia</th>
        <th>Fecha Ingreso</th>
        <th>Fecha Retiro</th>
        <th>Cargo</th>
        <th>Area</th>
        <th>Lider Inmediato</th>
        <th>Caja</th>
        <th>EPS</th>
        <th>ARL</th>
        <th>Pensiones</th>
        <th>Cesantias</th>               
        <th>Tipo Contrato</th>
        
      </tr>";

while ($fila = mysqli_fetch_array($resultado)) {
    echo "<tr>";
    echo "<td>" . $fila['estado'] . "</td>";
    echo "<td>" . $fila['cedula'] . "</td>";
    echo "<td>" . $fila['nombres'] . " " . $fila['apellidos'] . "</td>";
    echo "<td>" . $fila['edad'] . "</td>";
    echo "<td>" . $fila['celular'] . "</td>";
    echo "<td>" . $fila['correo'] . "</td>";
    echo "<td>" . $fila['direccion'] . "</td>";
    echo "<td>" . $fila['ciudad_residencia'] . "</td>";
    echo "<td>" . $fila['fecha_ingreso'] . "</td>";
    echo "<td>" . $fila['fecha_retiro'] . "</td>";
    echo "<td>" . $fila['cargo'] . "</td>";
    echo "<td>" . $fila['area'] . "</td>";
    echo "<td>" . $fila['lider_inmediato'] . "</td>";
    echo "<td>" . $fila['caja'] . "</td>";
    echo "<td>" . $fila['eps'] . "</td>";
    echo "<td>" . $fila['arl'] . "</td>";
    echo "<td>" . $fila['pensiones'] . "</td>";
    echo "<td>" . $fila['cesantias'] . "</td>";
    echo "<td>" . $fila['tipo_contrato'] . "</td>";
    echo "</tr>";
}

echo "</table>";
?>
