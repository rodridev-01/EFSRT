<?php
include 'db_conexion.php';

$query = "CALL obtener_departamentos()";
$result = $conexion->query($query);
$departamentos = [];

while ($row = $result->fetch_assoc()) {
    $departamentos[] = $row['nomDptoUbi'];
}

echo implode(',', $departamentos);
$conexion->close();
?>