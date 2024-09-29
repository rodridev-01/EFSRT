<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../formulario_fut/php/db_conexion.php';

if (isset($_POST['fut'])) {
    $futSeleccionado = $_POST['fut'];

    $sql = "SELECT nroFut, anioFut, fecHorIng, solicito, estado FROM fut WHERE nroFut = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $futSeleccionado);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $futDetails = $result->fetch_assoc();
        echo "<h3>Detalles del FUT Seleccionado:</h3>";
        echo "<p><strong>Número FUT:</strong> " . htmlspecialchars($futDetails['nroFut']) . "</p>";
        echo "<p><strong>Año FUT:</strong> " . htmlspecialchars($futDetails['anioFut']) . "</p>";
        echo "<p><strong>Fecha y Hora de Ingreso:</strong> " . htmlspecialchars($futDetails['fecHorIng']) . "</p>";
        echo "<p><strong>Solicitud:</strong> " . htmlspecialchars($futDetails['solicito']) . "</p>";
        echo "<p><strong>Estado:</strong> " . htmlspecialchars($futDetails['estado']) . "</p>";
    } else {
        echo "No se encontraron detalles para el FUT seleccionado.";
    }

    $stmt->close();
} else {
    echo "No se ha seleccionado ningún FUT.";
}
?>
