<?php
$host = 'localhost';
$user = 'liveraco_pruebabd';
$pass = 'JosePardo*2411';
$db = 'liveraco_efsrtBD';
$conexion = new mysqli($host, $user, $pass, $db);

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}
?>