<?php
session_start(); // Iniciar sesión

// Verificar si existe codLogin en la sesión
if (!isset($_SESSION['codLogin'])) {
  echo "No se encontró un código de usuario válido. Inicia sesión nuevamente.";
  exit;
}

// Conexión a la base de datos
$servername = "localhost";
$username = "liveraco_pruebabd";
$password = "JosePardo*2411";
$dbname = "liveraco_efsrtBD";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
  die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el codLogin de la sesión
$codLogin = $_SESSION['codLogin'];

// Consulta para obtener los datos del ingresante
$sql = "SELECT nombres, apPaterno, apMaterno, tipoDocu, nroDocu, codModular, telf, celular, correoJP, correoPersonal, direccion, codDis, codEsp, anioIngreso, anioEgreso 
        FROM solicitante 
        WHERE codLogin = ?
        ORDER BY codLogin DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $codLogin);
$stmt->execute();
$resultado = $stmt->get_result();
// CÓDIGO PARA OBTENER NOMBRES Y APELLIDOS DEL USUARIO PARA PODER IMPRIMIRSE EN

$sqlSolicitante = "SELECT nombres, apPaterno, apMaterno FROM solicitante WHERE codLogin = ?";
$stmtSolicitante = $conn->prepare($sqlSolicitante);
$stmtSolicitante->bind_param("i", $codLogin);
$stmtSolicitante->execute();
$resultSolicitante = $stmtSolicitante->get_result();

$rowSolicitante = $resultSolicitante->fetch_assoc();
$nombres = $rowSolicitante['nombres'];
$apPaterno = $rowSolicitante['apPaterno'];
$apMaterno = $rowSolicitante['apMaterno'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
  <link rel="stylesheet" href="../styles/default_user.css">
  <link href="../../../src/images/Logo.ico" rel="icon">
  <script defer src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
  <script defer src="../main.js"></script>
  <title>EFSRT Dashboard</title>
</head>

<body>
  <nav class="main-menu">
    <div>
      <div class="logo">
        <img
          src="../../../src/images/Logo.ico"
          alt="logo" />
      </div>

      <div class="user-info">
        <img src="https://cdn-icons-png.flaticon.com/512/7816/7816916.png" alt="user" />
        <p><?php echo $nombres . ' ' . $apPaterno . ' ' . $apMaterno; ?></p>
      </div>
      <ul>
        <li class="nav-item active">
          <a href="user.php">
            <i class="fa fa-user nav-icon"></i>
            <span class="nav-text">Cuenta</span>
          </a>
        </li>

        <li class="nav-item">
          <a href="../home.php">
            <i class="fa-solid fa-table nav-icon"></i>
            <span class="nav-text">Tablero</span>
          </a>
        </li>

        <li class="nav-item">
          <a href="formularioFUT.php">
            <i class="fa fa-arrow-trend-up nav-icon"></i>
            <span class="nav-text">Tramite</span>
          </a>
        </li>

        <li class="nav-item">
          <a href="estado.php">
            <i class="fa-solid fa-chart-simple nav-icon"></i>
            <span class="nav-text">Estado de FUTs</span>
          </a>
        </li>
        <br>

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
        <div class="user-profile">
          <h1>Perfil de Usuario</h1>
          <div class="user-container">
            <?php
            if ($resultado->num_rows > 0) {
              // Mostrar los datos de la tabla
              while ($fila = $resultado->fetch_assoc()) {
                // Captura la especialidad mediante el codigo de especialidad y lo muestra
                $codEsp = $fila['codEsp'];
                $sqlEsp = "SELECT nomEsp FROM especialidad WHERE codEsp = ?";
                $stmtEsp = $conn->prepare($sqlEsp);
                $stmtEsp->bind_param("i", $codEsp);
                $stmtEsp->execute();
                $resultEsp = $stmtEsp->get_result();
                $filaEsp = $resultEsp->fetch_assoc();
                $nomEsp = $filaEsp['nomEsp'];
            ?>
                <div class="profile-container">
                  <img src="https://cdn-icons-png.flaticon.com/512/7816/7816916.png" alt="user" />
                  <div>
                    <?php
                    echo "<p><strong>Nombres:</strong>" . $fila['nombres'] . "</p>";
                    echo "<p><strong>Apellido Paterno:</strong>" . $fila['apPaterno'] . "</p>";
                    echo "<p><strong>Apellido Materno:</strong>" . $fila['apMaterno'] . "</p>";
                    ?>
                  </div>
                </div>
                <div class="data-container">
                  <div class="data-column">
                    <?php
                    echo "<div><span><strong>Tipo de Documento:</strong></span><p>" . $fila['tipoDocu'] . "</p></div>";
                    echo "<div><span><strong>Teléfono:</strong></span><p> " . $fila['telf'] . "</p></div>";
                    echo "<div><span><strong>Celular:</strong></span><p> " . $fila['celular'] . "</p></div>";
                    echo "<div><span><strong>Especialidad:</strong></span><p> " . $nomEsp . "</p></div>";
                    ?>
                  </div>
                  <div class="data-column">
                    <?php
                    echo "<div><span><strong>Número de Documento:</strong></span><p>" . $fila['nroDocu'] . "</p></div>";
                    echo "<div><span><strong>Correo JP:</strong></span><p> " . $fila['correoJP'] . "</p></div>";
                    echo "<div><span><strong>Dirección:</strong></span><p> " . $fila['direccion'] . "</p></div>";
                    echo "<div><span><strong>Año de Ingreso:</strong></span><p> " . $fila['anioIngreso'] . "</p></div>";
                    ?>
                  </div>
                  <div class="data-column">
                    <?php
                    echo "<div><span><strong>Código Modular:</strong></span><p> " . $fila['codModular'] . "</p></div>";
                    echo "<div><span><strong>Correo Personal:</strong></span><p> " . $fila['correoPersonal'] . "</p></div>";
                    echo "<div><span><strong>Código de Distrito:</strong></span><p> " . $fila['codDis'] . "</p></div>";
                    echo "<div><span><strong>Año de Egreso:</strong></span><p> " . $fila['anioEgreso'] . "</p></div>";
                    ?>
                  </div>
                </div>
            <?php
              }
            } else {
              echo "<p>No se encontraron datos para este usuario.</p>";
            }
            // Cerrar la conexión
            $stmt->close();
            $conn->close();
            ?>
          </div>
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