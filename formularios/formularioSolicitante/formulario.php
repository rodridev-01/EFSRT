<?php
var_dump($_POST); // Esto te mostrará todos los datos enviados

include "php/db_conexion.php";

// Obtener el último valor de la columna codLogin
$sqlLastLogin = "SELECT codLogin FROM login ORDER BY codLogin DESC LIMIT 1";
$resultLastLogin = $conexion->query($sqlLastLogin);

if ($resultLastLogin->num_rows > 0) {
    $rowLastLogin = $resultLastLogin->fetch_assoc();
    $codLogin = $rowLastLogin['codLogin'];
} else {
    echo "No se encontró ningún registro en la tabla login.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    $departamento = $_POST['departamento'];
    $provincia = $_POST['provincia'];
    $distrito = $_POST['codDis'];

    // Obtener el código de ubigeo
    $queryUbigeo = "CALL obtener_codigo_ubigeo(?, ?, ?)";
    $stmtUbigeo = $conexion->prepare($queryUbigeo);
    $stmtUbigeo->bind_param("sss", $departamento, $provincia, $distrito);
    $stmtUbigeo->execute();
    $resultUbigeo = $stmtUbigeo->get_result();
    
    if ($resultUbigeo->num_rows > 0) {
        $rowUbigeo = $resultUbigeo->fetch_assoc();
        $codDis = $rowUbigeo['codUbi'];
    } else {
        echo "No se encontró el código de ubigeo para el distrito seleccionado.";
        exit();
    }
    $stmtUbigeo->close();

    $apPaterno = $_POST['apPaterno'] ?? '';
    $apMaterno = $_POST['apMaterno'] ?? '';
    $nombres = $_POST['nombres'] ?? '';
    $tipoDocu = $_POST['tipoDocu'] ?? '';
    $numDocu = $_POST['nroDocu'] ?? '';
    $codModular = $_POST['codModular'] ?? '';
    $telefono = $_POST['telf'] ?? '';
    $celular = $_POST['celular'] ?? '';
    $correoJP = $_POST['correoJP'] ?? '';
    $correoPersonal = $_POST['correoPersonal'] ?? '';
    $direccion = $_POST['direccion'] ?? '';
    $codEsp = $_POST['codigoEspecialidad'] ?? NULL;
    $anioIngreso = $_POST['anioIngreso'] ?? '';
    $anioEgreso = $_POST['anioEgreso'] ?? '';

    // Verificar el valor de codEsp
    var_dump($codEsp); // Para asegurarte de que estás recibiendo el valor

    try {
        // Preparar la consulta SQL
        $stmt = $conexion->prepare("INSERT INTO solicitante (codLogin, apPaterno, apMaterno, nombres, tipoDocu, nroDocu, codModular, telf, celular, correoJP, correoPersonal, direccion, codDis, codEsp, anioIngreso, anioEgreso) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        // Verificar si el prepare se ejecuta correctamente
        if ($stmt === false) {
            throw new Exception('Error en el prepare statement: ' . htmlspecialchars($conexion->error));
        }

        // Vincular los parámetros
        $stmt->bind_param("issssssssssssiii", $codLogin, $apPaterno, $apMaterno, $nombres, $tipoDocu, $numDocu, $codModular, $telefono, $celular, $correoJP, $correoPersonal, $direccion, $codDis, $codEsp, $anioIngreso, $anioEgreso);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "<h1>Solicitud enviada correctamente.</h1>";
            echo "<p>Gracias por completar el formulario. Puedes generar tu reporte PDF a continuación:</p>";

            // Formulario oculto para enviar los datos a PruebaV.php
            echo '
            <form action="fpdf/PruebaV.php" method="POST">
                <input type="hidden" name="apPaterno" value="' . htmlspecialchars($apPaterno) . '">
                <input type="hidden" name="apMaterno" value="' . htmlspecialchars($apMaterno) . '">
                <input type="hidden" name="nombres" value="' . htmlspecialchars($nombres) . '">
                <input type="hidden" name="tipoDocu" value="' . htmlspecialchars($tipoDocu) . '">
                <input type="hidden" name="nroDocu" value="' . htmlspecialchars($numDocu) . '">
                <input type="hidden" name="codModular" value="' . htmlspecialchars($codModular) . '">
                <input type="hidden" name="telf" value="' . htmlspecialchars($telefono) . '">
                <input type="hidden" name="celular" value="' . htmlspecialchars($celular) . '">
                <input type="hidden" name="correoJP" value="' . htmlspecialchars($correoJP) . '">
                <input type="hidden" name="correoPersonal" value="' . htmlspecialchars($correoPersonal) . '">
                <input type="hidden" name="direccion" value="' . htmlspecialchars($direccion) . '">
                <input type="hidden" name="codDis" value="' . htmlspecialchars($codDis) . '">
                <input type="hidden" name="codEsp" value="' . htmlspecialchars($codEsp) . '">
                <input type="hidden" name="anioIngreso" value="' . htmlspecialchars($anioIngreso) . '">
                <input type="hidden" name="anioEgreso" value="' . htmlspecialchars($anioEgreso) . '">
                <button type="submit">Generar Reporte PDF</button>
            </form>';
            
        }
        else {
            throw new Exception("Error al enviar la solicitud: " . $stmt->error);
        }
        

        // Cerrar la declaración
        $stmt->close();
    } catch (Exception $e) {
        echo "Excepción capturada: " . $e->getMessage();
    } finally {
        // Cerrar la conexión
        $conexion->close();
    }
} else {
    echo "No se recibieron datos.";
}

?>
<button type="button" onclick="window.location.href='../'">Iniciar sesion con nueva cuenta</button> 

