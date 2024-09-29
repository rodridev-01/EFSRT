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
            'mensaje' => 'El c贸digo de distrssito no existe en la base de datos.',
            'codigo' => $codDis  // Incluyendo el c贸digo de distrito que se est谩 verificando
        ]);
    }
} else {
    echo json_encode(['existe' => false, 'mensaje' => 'C贸digo de distrito no definido.']);
}
?>
