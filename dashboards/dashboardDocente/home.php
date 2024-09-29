<?php
session_start();
$codSoli = $_SESSION['codLogin'];
include 'src/php/db_conexion.php';

// Para jalar los datos e imprimirse
$sqlSolicitante = "SELECT nombres, apPaterno, apMaterno FROM solicitante WHERE codLogin = ?";
$stmtSolicitante = $conexion->prepare($sqlSolicitante);
$stmtSolicitante->bind_param("i", $codSoli);
$stmtSolicitante->execute();
$resultSolicitante = $stmtSolicitante->get_result();
$rowSolicitante = $resultSolicitante->fetch_assoc();
$nombres = $rowSolicitante['nombres'];
$apPaterno = $rowSolicitante['apPaterno'];
$apMaterno = $rowSolicitante['apMaterno'];

// Para jalar todos los datos de FUTs y mostrarlos
$sqlFut = "SELECT nroFut, anioFut, fecHorIng, solicito, estado FROM fut WHERE CodDocente = ?";
$stmtFut = $conexion->prepare($sqlFut);
$stmtFut->bind_param("i", $codSoli);
$stmtFut->execute();
$resultFut = $stmtFut->get_result();

//Para jalar los datos del docente e imprimirlos
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
  <link href="../../../src/images/Logo.ico" rel="icon">
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
        <img src="../../src/images/Logo.ico" alt="logo" />
      </div>

      <div class="user-info">
        <img src="https://cdn-icons-png.flaticon.com/512/7816/7816916.png" alt="user" />
        <p><?php echo $nombres . ' ' . $apPaterno . ' ' . $apMaterno; ?></p>
      </div>

      <ul>
        <li class="nav-item">
          <a href="pages/user.php">
            <i class="fa fa-user nav-icon"></i>
            <span class="nav-text">Cuenta</span>
          </a>
        </li>

        <li class="nav-item active">
          <a href="home.php">
            <i class="fa-solid fa-table nav-icon"></i>
            <span class="nav-text">Tablero</span>
          </a>
        </li>

        <li class="nav-item">
          <a href="pages/formularioFUT.php">
            <i class="fa fa-arrow-trend-up nav-icon"></i>
            <span class="nav-text">Tramite</span>
          </a>
        </li>

        <li class="nav-item">
          <a href="pages/estado.php">
            <i class="fa-solid fa-chart-simple nav-icon"></i>
            <span class="nav-text">Estado deFUTS</span>
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
        <form class="search-box">
          <input type="text" placeholder="Buscar..." />
          <i class="bx bx-search"></i>
        </form>
      </div>

      <div class="upcoming-events">
        <!-- Para mostrar el fut en el dashboard -->
        <h1>FUTs Asignados</h1>
        <div class="input-row">
          <div class="especialidad">
          </div>
        </div>
        <div class="fut-container">
          <?php while ($rowFut = $resultFut->fetch_assoc()) { ?>
            <div class="card fut-card">
              <p><strong>Número FUT:</strong> <?php echo $rowFut['nroFut']; ?></p>
              <p><strong>Año FUT:</strong> <?php echo $rowFut['anioFut']; ?></p>
              <p><strong>Fecha y Hora de Ingreso:</strong> <?php echo $rowFut['fecHorIng']; ?></p>
              <p><strong>Solicitud:</strong> <?php echo $rowFut['solicito']; ?></p>
              <p><strong>Estado:</strong>
                <?php
                if ($rowFut['estado'] == 'A') {
                  echo 'Aprobado';
                } else if ($rowFut['estado'] == 'D') {
                  echo 'Desaprobado';
                } else if ($rowFut['estado'] == 'H') {
                  echo 'Habilitado';
                }
                ?>

                <!-- Botón para enviar datos de este FUT -->
              <form action="pages/formularioFUT.php" method="post">
                <input type="hidden" name="nroFut" value="<?php echo $rowFut['nroFut']; ?>">
                <input type="hidden" name="anioFut" value="<?php echo $rowFut['anioFut']; ?>">
                <input type="hidden" name="fecHorIng" value="<?php echo $rowFut['fecHorIng']; ?>">
                <input type="hidden" name="solicito" value="<?php echo $rowFut['solicito']; ?>">
                <input type="hidden" name="estado" value="<?php echo $rowFut['estado']; ?>">
                <button type="submit" class="fut-button">Revisar FUT</button>
              </form>
            </div>
          <?php } ?>
          <br>
        </div>
      </div>
    </div>

    <div class="right-content">
      <div class="interaction-control interactions">
        <i class="fa-regular fa-envelope notified"></i>
        <i class="fa-regular fa-bell notified"></i>
        <div class="toggle" onclick="switchTheme()">
          <div class="mode-icon moon">
            <i class="bx bxs-moon"></i>
          </div>
          <div class="mode-icon sun hidden">
            <i class="bx bxs-sun"></i>
          </div>
        </div>
      </div>

      <div class="analytics">
        <h1>Analisis</h1>
        <div class="analytics-container">
          <div class="total-events">
            <div class="event-number card">
              <h2>Aprobados</h2>
              <p>1</p>
              <i class="bx bx-check-circle"></i>
            </div>
            <div class="event-number card">
              <h2>Pendientes</h2>
              <p>2</p>
              <i class="bx bx-timer"></i>
            </div>
          </div>

          <div class="chart" id="doughnut-chart">
            <h2>Porcentaje del Tramite</h2>
            <canvas id="doughnut"></canvas>
            <ul></ul>
          </div>
        </div>
      </div>

      <div class="contacts">
        <h1>Contactos</h1>
        <div class="contacts-container">
          <div class="contact-status">
            <div class="contact-activity">
              <img
                src="https://cdn-icons-png.flaticon.com/512/7816/7816916.png"
                alt="User Icon" />
              <p>Usuario <span><a target="_blank"
                    href="#">Developer</a></span></p>
            </div>
            <small>1 hour ago</small>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>

</html>