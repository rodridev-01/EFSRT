<?php
include 'php/db_conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nroFut = $_POST['nroFut']; // Número de identificación del registro para buscar en la BD
    echo "Número FUT recibido: " . $nroFut . "<br>"; // Depuración

    // Ruta donde se guardan los archivos
    $uploadDir = '../../dashboardDocente/formulario_fut/uploads/';
    
    // Verificar si se subió un nuevo archivo
    if (isset($_FILES['nuevoDocumento']) && $_FILES['nuevoDocumento']['error'] === UPLOAD_ERR_OK) {
        $newFileName = $_FILES['nuevoDocumento']['name'];
        $newFileTmpPath = $_FILES['nuevoDocumento']['tmp_name'];

        // Consulta para obtener el nombre del archivo existente en la BD
        $query = "SELECT archivo_pdf FROM fut WHERE nroFut = ?";
        $stmt = mysqli_prepare($conexion, $query);
        mysqli_stmt_bind_param($stmt, 'i', $nroFut);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $existingFile);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        // Si hay un archivo existente, lo eliminamos
        if ($existingFile && file_exists($uploadDir . $existingFile)) {
            echo "Eliminando archivo existente: " . $existingFile . "<br>"; // Depuración
            if (!unlink($uploadDir . $existingFile)) {
                echo "Error al eliminar el archivo existente.";
                exit;
            }
        } else {
            echo "No hay archivo existente para eliminar.<br>"; // Depuración
        }

        // Generar un nuevo nombre de archivo único (mantener la extensión original)
        $fileExtension = pathinfo($newFileName, PATHINFO_EXTENSION);
        $newFileName = uniqid('fut_' . $nroFut . '_') . '.' . $fileExtension;
        $newFilePath = $uploadDir . $newFileName;

        // Mover el nuevo archivo a la carpeta de destino
        if (move_uploaded_file($newFileTmpPath, $newFilePath)) {
            echo "Archivo movido correctamente a: " . $newFilePath . "<br>"; // Depuración
            
            // Actualizar la base de datos con el nuevo nombre de archivo
            $query = "UPDATE fut SET archivo_pdf = ? WHERE nroFut = ?";
            $stmt = mysqli_prepare($conexion, $query);
            mysqli_stmt_bind_param($stmt, 'si', $newFileName, $nroFut);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            
            echo "Archivo reemplazado y actualizado correctamente.";
            echo '<a href="../home.php">Regresar</a>';
        } else {
            echo "Error al mover el archivo a la carpeta de destino.";
        }
    } else {
        echo "No se ha subido ningún archivo.";
    }
} else {
    echo "Método de solicitud no permitido.";
}
?>