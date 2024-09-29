<?php
// Mostrar errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verificar si se reciben datos del formulario por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Incluir la librería FPDF
    require('../fpdf/fpdf.php');

    // Variables que vienen del formulario
    $apPaterno = isset($_POST['apPaterno']) ? $_POST['apPaterno'] : '';
    $apMaterno = isset($_POST['apMaterno']) ? $_POST['apMaterno'] : '';
    $nombres = isset($_POST['nombres']) ? $_POST['nombres'] : '';
    $tipoDocu = isset($_POST['tipoDocu']) ? $_POST['tipoDocu'] : '';
    $nroDocu = isset($_POST['nroDocu']) ? $_POST['nroDocu'] : '';
    $codModular = isset($_POST['codModular']) ? $_POST['codModular'] : '';
    $telf = isset($_POST['telf']) ? $_POST['telf'] : '';
    $celular = isset($_POST['celular']) ? $_POST['celular'] : '';
    $correoJP = isset($_POST['correoJP']) ? $_POST['correoJP'] : '';
    $correoPersonal = isset($_POST['correoPersonal']) ? $_POST['correoPersonal'] : '';
    $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : '';
    $codDis = isset($_POST['codDis']) ? $_POST['codDis'] : '';
    $codEsp = isset($_POST['codEsp']) ? $_POST['codEsp'] : '';
    $anioIngreso = isset($_POST['anioIngreso']) ? $_POST['anioIngreso'] : '';
    $anioEgreso = isset($_POST['anioEgreso']) ? $_POST['anioEgreso'] : '';

    // Crear el objeto PDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);

    // Título del documento
    $pdf->Cell(0, 10, 'Solicitud de Ingreso', 0, 1, 'C');
    $pdf->Ln(10);  // Espacio

    // Incluir los datos recibidos del formulario
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'Apellido Paterno: ' . $apPaterno, 0, 1);
    $pdf->Cell(0, 10, 'Apellido Materno: ' . $apMaterno, 0, 1);
    $pdf->Cell(0, 10, 'Nombres: ' . $nombres, 0, 1);
    $pdf->Cell(0, 10, 'Tipo de Documento: ' . $tipoDocu, 0, 1);
    $pdf->Cell(0, 10, 'Numero de Documento: ' . $nroDocu, 0, 1);
    $pdf->Cell(0, 10, 'Codigo Modular: ' . $codModular, 0, 1);
    $pdf->Cell(0, 10, 'Telefono: ' . $telf, 0, 1);
    $pdf->Cell(0, 10, 'Celular: ' . $celular, 0, 1);
    $pdf->Cell(0, 10, 'Correo Institucional: ' . $correoJP, 0, 1);
    $pdf->Cell(0, 10, 'Correo Personal: ' . $correoPersonal, 0, 1);
    $pdf->Cell(0, 10, 'Direccion: ' . $direccion, 0, 1);
    $pdf->Cell(0, 10, 'Codigo Distrito: ' . $codDis, 0, 1);
    $pdf->Cell(0, 10, 'Codigo Especialidad: ' . $codEsp, 0, 1);
    $pdf->Cell(0, 10, 'Año de Ingreso: ' . $anioIngreso, 0, 1);
    $pdf->Cell(0, 10, 'Año de Egreso: ' . $anioEgreso, 0, 1);

    // Salida del PDF
    $pdf->Output('I', 'Solicitud.pdf');
} else {
    echo "No se recibieron datos. Por favor, completa el formulario.";
}
?>
