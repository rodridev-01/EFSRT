<?php
session_start();
include 'php/db_conexion.php';

// Inicializamos variables
$nuevoNroFut = $_POST['nroFut'] ?? null;
$anioFut = date('Y');
$codTT = $_POST['tipoTramite'];
$solicito = $_POST['solicitud']; // Descripción de la solicitud
$codSoli = $_SESSION['codLogin']; // Código momentáneo para probar envíos

// Fecha y hora actuales
$fechaHoraActual = date('Y-m-d H:i:s');

// CÓDIGO PARA OBTENER NOMBRES Y APELLIDOS DEL USUARIO PARA PODER IMPRIMIRSE EN EL PDF
$sqlSolicitante = "SELECT nombres, apPaterno, apMaterno FROM solicitante WHERE codLogin = ?";
$stmtSolicitante = $conexion->prepare($sqlSolicitante);
$stmtSolicitante->bind_param("i", $codSoli);
$stmtSolicitante->execute();
$resultSolicitante = $stmtSolicitante->get_result();

if ($resultSolicitante->num_rows > 0) {
    $rowSolicitante = $resultSolicitante->fetch_assoc();
    $nombres = $rowSolicitante['nombres'];
    $apPaterno = $rowSolicitante['apPaterno'];
    $apMaterno = $rowSolicitante['apMaterno'];
} else {
    echo "No se encontraron datos para el codLogin proporcionado.";
    echo isset($_SESSION['codLogin']) ? $_SESSION['codLogin'] : 'Usuario';
    exit();
}
$stmtSolicitante->close();

$query = "INSERT INTO fut (anioFut, fecHorIng, codTT, solicito, codSoli, fecHoraAsignaDocente, fecHoraNotificaSolicitante, fecHoraSubePrimerFormato, fecHoraSubeUltimoFormato, fecHoraDocenteCierraFut, descDocenteCierraFut, fecHoraCoordCierraFut, descCoorCierraFut, estado) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conexion, $query);

if ($stmt) {
    // Variables para los campos opcionales que pueden ser nulos
    $fecHoraAsignaDocente = null;
    $fecHoraNotificaSolicitante = null;
    $fecHoraSubePrimerFormato = null;
    $fecHoraSubeUltimoFormato = null;
    $fecHoraDocenteCierraFut = null;
    $descDocenteCierraFut = null;
    $fecHoraCoordCierraFut = null;
    $descCoorCierraFut = null;

    // Asignar los valores a la consulta
    $estado = 'H'; // Valor por defecto para estado
    mysqli_stmt_bind_param($stmt, 'isssssssssssss', 
    $anioFut, 
    $fechaHoraActual, 
    $codTT, 
    $solicito, // Asegúrate de que esta sea 's'
    $codSoli, 
    $fecHoraAsignaDocente, 
    $fecHoraNotificaSolicitante, 
    $fecHoraSubePrimerFormato, 
    $fecHoraSubeUltimoFormato, 
    $fecHoraDocenteCierraFut, 
    $descDocenteCierraFut, 
    $fecHoraCoordCierraFut, 
    $descCoorCierraFut, 
    $estado
);

    if (mysqli_stmt_execute($stmt)) {
    echo "<h1>Solicitud enviada correctamente.</h1>";
    echo "<p>Gracias por completar el formulario. Puedes generar tu reporte PDF a continuación:</p>";

    // Formulario oculto para enviar los datos a PruebaV.php en una nueva ventana
    echo '
    <form action="fpdf/PruebaV.php" method="POST" target="_blank">
        <input type="hidden" name="codsoli" value="' . htmlspecialchars($codSoli) . '">
        <input type="hidden" name="apPaterno" value="' . htmlspecialchars($apPaterno) . '">
        <input type="hidden" name="apMaterno" value="' . htmlspecialchars($apMaterno) . '">
        <input type="hidden" name="nombres" value="' . htmlspecialchars($nombres) . '">
        <input type="hidden" name="aniofut" value="' . htmlspecialchars($anioFut) . '">
        <input type="hidden" name="codtt" value="' . htmlspecialchars($codTT) . '">
        <input type="hidden" name="solicito" value="' . htmlspecialchars($solicito) . '">
        <button type="submit">Generar Reporte PDF</button>
    </form>';
        ?>

        <button type="button" onclick="window.location.href='../home.php'">Redirigir al Home</button>

        <?php
        exit;
    } else {
        echo "Error al ingresar la solicitud: " . mysqli_error($conexion);
    }

    mysqli_stmt_close($stmt);
} else {
    echo "Error en la preparación de la consulta: " . mysqli_error($conexion);
}

mysqli_close($conexion);
?>
