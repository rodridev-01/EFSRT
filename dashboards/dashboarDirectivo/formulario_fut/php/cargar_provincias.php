<?php
include 'db_conexion.php';

if (isset($_POST['departamento'])) {
    $departamento = $_POST['departamento'];

    $query = "CALL obtener_provincias(?)";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("s", $departamento);
    $stmt->execute();
    $result = $stmt->get_result();

    $provincias = [];
    while ($row = $result->fetch_assoc()) {
        $provincias[] = $row['nomProvUbi'];
    }

    echo implode(',', $provincias);
    $conexion->close();
} else {
    echo "Error: departamento no definido.";
}
?>