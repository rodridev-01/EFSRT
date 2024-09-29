<?php
session_start();
include '../formulario_fut/php/db_conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codDocente = $_POST['docente'];
    $nroFut = $_POST['fut'];
    $descripcion = $_POST['descripcion'];

    // Obtener la fecha y hora actuales
    $fechaHoraActual = date('Y-m-d H:i:s');

    // Actualizar el estado del FUT y asignar el docente
    $sqlUpdate = "UPDATE fut 
                  SET CodDocente = ?, estado = 'A', Descripcion = ?, 
                      fecHoraAsignaDocente = ?, fecHoraNotificaSolicitante = ?
                  WHERE nroFut = ?";

    $stmt = $conexion->prepare($sqlUpdate);
    $stmt->bind_param("ssssi", $codDocente, $descripcion, $fechaHoraActual, $fechaHoraActual, $nroFut);

    if ($stmt->execute()) {
        echo "<script>alert('FUT asignado exitosamente'); window.location.href='http://grupo1.live-ra.com/pruebasxamp/dashboardcoordinador/home.php';</script>";
    } else {
        echo "<script>alert('Error al asignar FUT: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}
?>