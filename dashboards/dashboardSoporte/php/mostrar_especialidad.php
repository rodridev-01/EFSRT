<?php
include 'php/db_conexion.php';

$query = "CALL obtener_especialidades()";
$result = $conexion->query($query);

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    echo "<option value='" . $row['codEsp'] . "'>" . $row['nomEsp'] . "</option>";
  }
}
?>