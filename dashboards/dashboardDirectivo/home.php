<?php
session_start();
$codSoli = $_SESSION['codLogin'];
include 'formulario_fut/php/db_conexion.php';

// Para jalar los datos y imprimirse
$sqlSolicitante = "SELECT nombres, apPaterno, apMaterno FROM personal WHERE codLogin = ?";
$stmtSolicitante = $conexion->prepare($sqlSolicitante);
$stmtSolicitante->bind_param("i", $codSoli);
$stmtSolicitante->execute();
$resultSolicitante = $stmtSolicitante->get_result();
$rowSolicitante = $resultSolicitante->fetch_assoc();
$nombres = $rowSolicitante['nombres'];
$apPaterno = $rowSolicitante['apPaterno'];
$apMaterno = $rowSolicitante['apMaterno'];

// Para jalar los datos y imprimirse
//$sqlSolicitante = "SELECT * from fut";
//$stmtSolicitante = $conexion->prepare($sqlSolicitante);
//$stmtSolicitante->bind_param("i", $codSoli);
//$stmtSolicitante->execute();
//$resultSolicitante = $stmtSolicitante->get_result();
//$rowSolicitante = $resultSolicitante->fetch_assoc();
//$nombres = $rowSolicitante['nombres'];
//$apPaterno = $rowSolicitante['apPaterno'];
//$apMaterno = $rowSolicitante['apMaterno']; 

// Para jalar los datos y mostrar del fut
$sqlFut = "SELECT nroFut, anioFut, fecHorIng, solicito,fecHoraNotificaSolicitante ,estado FROM fut";
$stmtFut = $conexion->prepare($sqlFut);
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
  <link href="Icons_Dash/Logo.ico" rel="icon">
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
        <img src="Icons_Dash/Logo.ico" alt="logo" />
      </div>

      <div class="user-info">
        <img src="https://cdn-icons-png.flaticon.com/512/7816/7816916.png" alt="user" />
        <p><?php echo $nombres . ' ' . $apPaterno . ' ' . $apMaterno; ?></p>
      </div>

      <ul>
        <li class="nav-item">
          <a href="Pages_Dash/user.php">
            <i class="fa fa-user nav-icon"></i>
            <span class="nav-text">Cuenta</span>
          </a>
        </li>
        
        <li class="nav-item active">
          <a href="../dashboardirectivo/home.php">
            <i class="fa-solid fa-table nav-icon"></i>
            <span class="nav-text">Tablero</span>
          </a>
        </li>

        <li class="nav-item">
          <!-- <a href="formulario_fut/formularioFUT.php"> -->
              <a href="#">
            <i class="fa fa-arrow-trend-up nav-icon"></i>
            <span class="nav-text">Tramite</span>
          </a>
        </li>

        <li class="nav-item">
          <a href="#">
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
        <a href="https://grupo1.live-ra.com/pruebasxamp/">
          <i class="fa fa-right-from-bracket nav-icon"></i>
          <span class="nav-text">Salir</span>
        </a>
      </li>
    </ul>
  </nav>
  
  
  <?php
                // Captura la especialidad mediante el codigo de especialidad y lo muestra
                            $codEsp = $fila['codEsp'];
                            $sqlEsp = "SELECT nomEsp FROM especialidad WHERE codEsp = ?";
                            $stmtEsp = $conexion->prepare($sqlEsp);
                            $stmtEsp->bind_param("i", $codEsp);
                            $stmtEsp->execute();
                            $resultEsp = $stmtEsp->get_result();
                            $filaEsp = $resultEsp->fetch_assoc();
                            $nomEsp = $filaEsp['nomEsp'];
                            
                            
    
    $codMod = $fila['codTT'];
    $sqlMod = "select descTT from tipoTramite where codTT = ?";
    $stmtMod = $conexion->prepare($sqlMod);
    $stmtMod->bind_param("i", $codMod);
    $stmtMod->execute();
    $resultMod = $stmtMod->get_result();
    $filaMod = $resultMod->fetch_assoc();
    $tramite = $filaMod['descTT'];
    ?>
    
  <section class="content">
    <div class="left-content">
      <div class="search-and-check">
        <form class="search-box">
          <input type="text" placeholder="Buscar..." />
          <i class="bx bx-search"></i>
        </form>
      </div>

      <div class="upcoming-events">
        <h1>Tablero</h1>
        
        <!-- Para mostrar el fut en el dashboard -->
        <h2>FUTs del Alumno</h2>
        <div class="fut-container">
          <?php while ($rowFut = $resultFut->fetch_assoc()) { ?>
            <div class="card fut-card">
                
                            
              <p><strong>Número FUT:</strong> <?php echo $rowFut['nroFut']; ?></p>
              <p><strong>Año FUT:</strong> <?php echo $rowFut['anioFut']; ?></p>
              <p><strong>Fecha y Hora de Ingreso:</strong> <?php echo $rowFut['fecHorIng']; ?></p>
              <p><strong>Solicitud:</strong> <?php echo $rowFut['solicito']; ?></p>
              <p><strong>Especialidad:</strong> <?php echo $nomEsp. "sadas"; ?></p>
              <p><strong>Estado:</strong> <?php echo $rowFut['estado'] == 'H' ? 'Habilitado' : 'Inhabilitado'; ?></p>
              
              <button onclick="toggleDetalles(this)">Ver detalles</button>

                <div class="detalles" style="display:none;">
                    <span> 
                        <p><strong>Nombre de Solicitante:</strong> <?php echo $nombres . ' ' . $apPaterno . ' ' . $apMaterno; ?></p>
                    </span>
                    
                    <span><p><strong>Fecha Solicitada : </strong> <?php echo $row['fecHoraNotificaSolicitante']; ?></p></span>
                    <span><p><strong>Modulo : </strong> <?php echo $tramite ; ?></p></span>
                </div>

            </div>
          <?php } ?>
        </div>
        
        
      </div>
      
        <script>
        function toggleDetalles(button) {
            // Encuentra el div de detalles (está en el mismo nivel que el botón)
            var detallesDiv = button.nextElementSibling;
        
            // Si los detalles están ocultos, los mostramos
            if (detallesDiv.style.display === "none") {
                detallesDiv.style.display = "block";
                button.textContent = "Ver menos";  // Cambiar texto a "Ver menos"
            } else {
                // Si ya están visibles, los ocultamos
                detallesDiv.style.display = "none";
                button.textContent = "Ver detalles";  // Cambiar texto a "Ver detalles"
            }
        }
        </script>
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
                    href="https://github.com/Alonso-dev651">Developer</a></span></p>
            </div>
            <small>1 hour ago</small>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>

</html>
