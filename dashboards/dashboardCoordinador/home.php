<?php
session_start();
$codSoli = $_SESSION['codLogin'];
include 'formulario_fut/php/db_conexion.php';

// Obtener datos del solicitante
$sqlSolicitante = "SELECT nombres, apPaterno, apMaterno FROM solicitante WHERE codLogin = ?";
$stmtSolicitante = $conexion->prepare($sqlSolicitante);
$stmtSolicitante->bind_param("i", $codSoli);
$stmtSolicitante->execute();
$resultSolicitante = $stmtSolicitante->get_result();
$rowSolicitante = $resultSolicitante->fetch_assoc();
$nombres = $rowSolicitante['nombres'];
$apPaterno = $rowSolicitante['apPaterno'];
$apMaterno = $rowSolicitante['apMaterno'];

// Recibir el término de búsqueda
$searchTerm = isset($_POST['search']) ? trim($_POST['search']) : '';

// Consulta para obtener los datos del FUT con o sin filtro de búsqueda
if (!empty($searchTerm)) {
  $sqlFut = "SELECT nroFut, anioFut, fecHorIng, solicito, estado FROM fut WHERE nroFut LIKE ?";
  $searchTerm = "%$searchTerm%";
  $stmtFut = $conexion->prepare($sqlFut);
  $stmtFut->bind_param("s", $searchTerm);
} else {
  $sqlFut = "SELECT nroFut, anioFut, fecHorIng, solicito, estado FROM fut";
  $stmtFut = $conexion->prepare($sqlFut);
}

$stmtFut->execute();
$resultFut = $stmtFut->get_result();
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
  <link href="./Pages_Dash/Logo.ico" rel="icon">
  <script defer src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
  <script defer src="main.js"></script>
  <title>EFSRT Dashboard</title>
</head>

<body>
  <nav class="main-menu">
    <div>
      <div class="logo">
        <img src="./Pages_Dash/Logo.ico" alt="logo" />
      </div>

      <div class="user-info">
        <img src="https://cdn-icons-png.flaticon.com/512/7816/7816916.png" alt="user" />
        <p><?php echo $nombres . ' ' . $apPaterno . ' ' . $apMaterno; ?></p>
      </div>

      <ul>
        <li class="nav-item">
          <a href="./Pages_Dash/user.php">
            <i class="fa fa-user nav-icon"></i>
            <span class="nav-text">Cuenta</span>
          </a>
        </li>

        <li class="nav-item active">
          <a href="../dashboardCoordinador/home.php">
            <i class="fa-solid fa-table nav-icon"></i>
            <span class="nav-text">Tablero</span>
          </a>
        </li>

        <li class="nav-item">
          <a href="./formulario_fut/formularioFUT.php">
            <i class="fa fa-arrow-trend-up nav-icon"></i>
            <span class="nav-text">Tramite</span>
          </a>
        </li>

        <li class="nav-item">
          <a href="./Estado_fut/estado.php">
            <i class="fa-solid fa-chart-simple nav-icon"></i>
            <span class="nav-text">Estado</span>
          </a>
        </li>

        <li class="nav-item">
          <a href="#">
            <i class="fa fa-circle-info nav-icon"></i>
            <span class="nav-text">Ayuda</span>
          </a>
        </li>
      </ul>
    </div>

    <ul>
      <li class="nav-item">
        <a href="https://proyecto.live-ra.com">
          <i class="fa fa-right-from-bracket nav-icon"></i>
          <span class="nav-text">Salir</span>
        </a>
      </li>
    </ul>
  </nav>

  <section class="content">
    <div class="left-content">
      <div class="search-and-check">
        <form class="search-box" method="POST" action="">
          <input type="text" name="search" placeholder="Buscar por número de FUT..." />
          <button type="submit"><i class="bx bx-search"></i></button>
        </form>
      </div>

      <div class="upcoming-events">
        <h1>Tablero</h1>

        <h2>FUTs del Alumno</h2>
        <div class="input-row">
          <div class="especialidad">
            <div class="form-group">

              <button onclick="window.location.href='../formulariodocs/formulariosdocs.php'" class="fut-button">Subir archivos</button>
              <label for="especialidad">Especialidades</label>

              <select id="especialida" name="especialidad" required>
                <option value="" disabled selected>Especialidad</option>
                <?php include './Mostrar/Mostrar_especialidades.php'; ?>
              </select>
            </div>
          </div>
        </div>

        <div class="fut-container">
          <?php while ($rowFut = $resultFut->fetch_assoc()) { ?>
            <div class="fut-card">
              <div class="fut-details">
                <p><strong>Número FUT:</strong> <?php echo $rowFut['nroFut']; ?></p>
                <p><strong>Año FUT:</strong> <?php echo $rowFut['anioFut']; ?></p>
                <p><strong>Fecha y Hora de Ingreso:</strong> <?php echo $rowFut['fecHorIng']; ?></p>
                <p><strong>Solicitud:</strong> <?php echo $rowFut['solicito']; ?></p>
                <p><strong>Estado:</strong> <?php echo $rowFut['estado'] == 'H' ? 'Habilitado' : 'Inhabilitado'; ?></p>
              </div>
              <form action="Asignar_fut/index.php" method="post" class="fut-form">
                <input type="hidden" name="nroFut" value="<?php echo $rowFut['nroFut']; ?>">
                <input type="hidden" name="anioFut" value="<?php echo $rowFut['anioFut']; ?>">
                <input type="hidden" name="fecHorIng" value="<?php echo $rowFut['fecHorIng']; ?>">
                <input type="hidden" name="solicito" value="<?php echo $rowFut['solicito']; ?>">
                <input type="hidden" name="estado" value="<?php echo $rowFut['estado']; ?>">
                <button type="submit" class="fut-button">Asignar Docente</button>
              </form>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>


  </section>
</body>

</html>