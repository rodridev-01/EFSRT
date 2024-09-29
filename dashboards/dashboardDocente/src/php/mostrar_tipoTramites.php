<?php
include 'db_conexion.php';

// Suponiendo que $codTTSeleccionado está disponible y contiene el valor del tipo de trámite seleccionado para el FUT
$query = "CALL obtener_tipoTramite()";
$result = $conexion->query($query);

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    // Verificar si el tipo de trámite actual es el seleccionado
    $selected = ($row['codTT'] == $codTTSeleccionado) ? 'selected' : '';
    // Mostrar descTT en el combobox
    echo "<option value='" . $row['codTT'] . "' $selected>" . $row['descTT'] . "</option>";
  }
}
?>