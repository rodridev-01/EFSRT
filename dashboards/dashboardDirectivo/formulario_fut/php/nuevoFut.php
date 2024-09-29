<?php
include 'db_conexion.php';

// Verificar la conexión
if (!$conexion) {
    die("Error en la conexión a la base de datos: " . mysqli_connect_error());
}

// Inicializamos el valor de nroFut
$nuevoNroFut = 1;

// Consulta para obtener el último nroFut
$query = "SELECT nroFut FROM fut ORDER BY nroFut DESC LIMIT 1";
$result = mysqli_query($conexion, $query);

// Verificamos si hay resultados
if ($result && mysqli_num_rows($result) > 0) {
    // Obtenemos el último nroFut
    $row = mysqli_fetch_assoc($result);
    $ultimoNroFut = $row['nroFut'];
    
    // Sumamos 1 al último nroFut
    $nuevoNroFut = $ultimoNroFut + 1;
}

// Cerramos la conexión a la base de datos
mysqli_close($conexion);
?>
