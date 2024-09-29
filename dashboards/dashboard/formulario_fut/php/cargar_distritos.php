<?php
include 'db_conexion.php';

if (isset($_POST['provincia'])) {
    $provincia = $_POST['provincia'];

    $query = "CALL obtener_distritos(?)";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("s", $provincia);
    $stmt->execute();
    $result = $stmt->get_result();

    $distritos = [];
    while ($row = $result->fetch_assoc()) {
        $distritos[] = $row['nomDisUbi'];
    }

    echo implode(',', $distritos);
    $conexion->close();
} else {
    echo "Error: provincia no definida.";
}
?>