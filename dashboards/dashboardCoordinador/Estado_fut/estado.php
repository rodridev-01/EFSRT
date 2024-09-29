<?php
include '../formulario_fut/php/db_conexion.php';
session_start();

// Recibir datos de home.php
$nroFut = $_POST['nroFut'] ?? '';
$anioFut = $_POST['anioFut'] ?? '';
$fecHorIng = $_POST['fecHorIng'] ?? '';
$solicito = $_POST['solicito'] ?? '';
$estado = $_POST['estado'] ?? '';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Detalles del FUT</title>
</head>
<body>
    <h1>Detalles del FUT</h1>
    <p><strong>Número FUT:</strong> <?php echo htmlspecialchars($nroFut); ?></p>
    <p><strong>Año FUT:</strong> <?php echo htmlspecialchars($anioFut); ?></p>
    <p><strong>Fecha y Hora de Ingreso:</strong> <?php echo htmlspecialchars($fecHorIng); ?></p>
    <p><strong>Solicitud:</strong> <?php echo htmlspecialchars($solicito); ?></p>
    <p><strong>Estado:</strong> <?php echo $estado == 'H' ? 'Habilitado' : 'Inhabilitado'; ?></p>

    <?php $conn->close(); ?>
</body>
</html>



