<?php
// Mostrar errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Iniciar sesión
session_start();

// Verificar si se recibe el codLogin en la sesión
if (!isset($_SESSION['codLogin'])) {
    die("Error: No se encontró el codLogin en la sesión.");
}

// Incluir la librería FPDF
require('../fpdf/fpdf.php');
include '../php/db_conexion.php';

// Obtener el codLogin de la sesión
$codLogin = $_SESSION['codLogin'];

// Obtener nombres y apellidos de la tabla solicitante basado en el codLogin
$querySolicitante = "SELECT nombres, apPaterno, apMaterno FROM solicitante WHERE codLogin = ?";
$stmtSolicitante = mysqli_prepare($conexion, $querySolicitante);
mysqli_stmt_bind_param($stmtSolicitante, "i", $codLogin);
mysqli_stmt_execute($stmtSolicitante);
mysqli_stmt_bind_result($stmtSolicitante, $nombres, $apPaterno, $apMaterno);
mysqli_stmt_fetch($stmtSolicitante);
mysqli_stmt_close($stmtSolicitante);

// Verificar si se encontraron resultados
if (empty($nombres) || empty($apPaterno) || empty($apMaterno)) {
    die("Error: No se encontraron nombres o apellidos para el codLogin proporcionado.");
}

// Variables que vienen del formulario
$anioFut = isset($_POST['aniofut']) ? $_POST['aniofut'] : '';
$tipoTramite = isset($_POST['codtt']) ? $_POST['codtt'] : '';
$solicitud = isset($_POST['solicito']) ? $_POST['solicito'] : '';
$descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : '';

// Crear el objeto PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Título del documento
$pdf->Cell(0, 10, 'SOLICITUD DE FUT PARA MODULO NUMERO '.$tipoTramite, 0, 1, 'C');
$pdf->Ln(10);  // Espacio

// Incluir los datos recibidos del formulario y de la base de datos
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Apellido Paterno: ' . $apPaterno, 0, 1);
$pdf->Cell(0, 10, 'Apellido Materno: ' . $apMaterno, 0, 1);
$pdf->Cell(0, 10, 'Nombres: ' . $nombres, 0, 1);
$pdf->Cell(0, 10, 'Año de la Solicitud: ' . $anioFut, 0, 1);
$pdf->Cell(0, 10, 'Tipo de Trámite: ' . $tipoTramite, 0, 1);
$pdf->Cell(0, 10, 'Solicitud: ' . $solicitud, 0, 1);
$pdf->Cell(0, 10, 'Descripción de la Solicitud: ' . $descripcion, 0, 1);

// Salida del PDF
$pdf->Output('I', 'Solicitud.pdf');

// Cerrar conexión a la base de datos
mysqli_close($conexion);
?>
