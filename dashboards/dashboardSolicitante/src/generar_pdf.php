<?php
require('fpdf/fpdf.php');

// Crear una instancia de FPDF
$pdf = new FPDF();
$pdf->AddPage();

// Titulo
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Reporte de Solicitud', 0, 1, 'C');

// Salto de linea
$pdf->Ln(10);

// Definir la fuente
$pdf->SetFont('Arial', '', 12);

// Obtener los datos del formulario
$departamento = $_POST['departamento'];
$provincia = $_POST['provincia'];
$distrito = $_POST['distrito'];
$telf = $_POST['telf'];
$celular = $_POST['celular'];
$especialidad = $_POST['especialidad'];
$semestre = $_POST['semestre'];
$correoPersonal = $_POST['correoPersonal'];
$turno = $_POST['turno'];
$anioIngreso = $_POST['anioIngreso'];
$anioEgreso = $_POST['anioEgreso'];
$detalle = $_POST['detalle'];
$observacion = $_POST['observacion'];

// Escribir los datos del formulario en el PDF
$pdf->Cell(40, 10, 'Departamento:');
$pdf->Cell(0, 10, $departamento, 0, 1);

$pdf->Cell(40, 10, 'Provincia:');
$pdf->Cell(0, 10, $provincia, 0, 1);

$pdf->Cell(40, 10, 'Distrito:');
$pdf->Cell(0, 10, $distrito, 0, 1);

$pdf->Cell(40, 10, 'Telefono:');
$pdf->Cell(0, 10, $telf, 0, 1);

$pdf->Cell(40, 10, 'Celular:');
$pdf->Cell(0, 10, $celular, 0, 1);

$pdf->Cell(40, 10, 'Especialidad:');
$pdf->Cell(0, 10, $especialidad, 0, 1);

$pdf->Cell(40, 10, 'Semestre:');
$pdf->Cell(0, 10, $semestre, 0, 1);

$pdf->Cell(40, 10, 'Correo Electronico:');
$pdf->Cell(0, 10, $correoPersonal, 0, 1);

$pdf->Cell(40, 10, 'Turno:');
$pdf->Cell(0, 10, $turno, 0, 1);

$pdf->Cell(40, 10, 'Anio de Ingreso:');
$pdf->Cell(0, 10, $anioIngreso, 0, 1);

$pdf->Cell(40, 10, 'Anio de Egreso:');
$pdf->Cell(0, 10, $anioEgreso, 0, 1);

$pdf->Cell(40, 10, 'Detalles:');
$pdf->Cell(0, 10, $detalle, 0, 1);

$pdf->Cell(40, 10, 'Observacion:');
$pdf->Cell(0, 10, $observacion, 0, 1);

// Generar y descargar el PDF
$pdf->Output('D', 'Reporte_Solicitud.pdf');
?>