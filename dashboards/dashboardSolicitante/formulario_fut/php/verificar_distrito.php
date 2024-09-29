<?php
include 'db_conexion.php';

if (isset($_POST['codDis'])) {
    $codDis = $_POST['codDis'];

    $query = "SELECT COUNT(*) FROM ubigeo WHERE codUbi = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("s", $codDis);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    $conexion->close();

    // Retornar la respuesta como JSON
    if ($count > 0) {
        echo json_encode(['existe' => true]);
    } else {
        echo json_encode([
            'existe' => false,
            'mensaje' => 'El código de distrssito no existe en la base de datos.',
            'codigo' => $codDis  // Incluyendo el código de distrito que se está verificando
        ]);
    }
} else {
    echo json_encode(['existe' => false, 'mensaje' => 'Código de distrito no definido.']);
}
?>
