<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include '../formulario_fut/php/db_conexion.php';

// Manejo de errores de conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nroFut = $_POST['nroFut'];
    $anioFut = $_POST['anioFut'];
    $fecHorIng = $_POST['fecHorIng'];
    $solicito = $_POST['solicito'];
    $estado = $_POST['estado'];
}

$sqlDocente = "SELECT codLogin, usuLogin FROM login WHERE tipoLogin = 'DOCENTE'";
$resultDocente = $conexion->query($sqlDocente);

if (!$resultDocente) {
    die("Error en la consulta de docentes: " . $conexion->error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
  <link rel="stylesheet" href="style.css">
  <title>Asignar FUT</title>
</head>

<body>
  <div class="container">
    <h1>Asignar Docente al FUT</h1>

    <div class="fut-info">
      <p><strong>Número FUT:</strong> <?php echo htmlspecialchars($nroFut); ?></p>
      <p><strong>Año FUT:</strong> <?php echo htmlspecialchars($anioFut); ?></p>
      <p><strong>Fecha y Hora de Ingreso:</strong> <?php echo htmlspecialchars($fecHorIng); ?></p>
      <p><strong>Solicitud:</strong> <?php echo htmlspecialchars($solicito); ?></p>
      <p><strong>Estado:</strong> <?php echo ($estado == 'H') ? 'Habilitado' : 'Inhabilitado'; ?></p>
    </div>

    <form action="asignar_fut.php" method="post">
      <input type="hidden" name="nroFut" value="<?php echo $nroFut; ?>">
      <input type="hidden" name="anioFut" value="<?php echo $anioFut; ?>">

      <div class="form-group">
        <label for="descripcion">Descripción</label>
        <textarea name="descripcion" id="descripcion" rows="3" required></textarea>
      </div>

      <div class="form-group">
        <label for="docente">Seleccionar Docente</label>
        <select name="docente" id="docente" required>
          <option value="" disabled selected>Seleccione un docente</option>
          <?php
          if ($resultDocente->num_rows > 0) {
              // Mostrar los docentes en el combobox
              while ($rowDocente = $resultDocente->fetch_assoc()) {
                  echo "<option value='" . htmlspecialchars($rowDocente['codLogin']) . "'>" . htmlspecialchars($rowDocente['usuLogin']) . "</option>";
              }
          } else {
              echo "<option value='' disabled>No hay docentes disponibles</option>";
          }
          ?>
        </select>
      </div>

      <button type="submit" class="fut-button">Asignar FUT al Docente</button>
    </form>
  </div>
</body>

</html>

<?php
$conexion->close();
?>
