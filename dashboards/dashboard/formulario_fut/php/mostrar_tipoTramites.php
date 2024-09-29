<?php
include 'db_conexion.php';

$query = "CALL obtener_tipoTramite()";
$result = $conexion->query($query);

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    echo "<option value='" . $row['codTT'] . "'>" . $row['descTT'] . "</option>";
  }
}
?>

