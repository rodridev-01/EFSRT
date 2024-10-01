<?php
session_start(); // Asegúrate de que las sesiones estén habilitadas

include("dashboards\dashboardSoporte\php\db_conexion.php");

// Usar un código fijo para esta consulta
$codLoginFijo = 74;

try {
  // Preparar la consulta
  $query = $pdo->prepare("SELECT codLogin, nombre, apellidos, email FROM usuarios WHERE codLogin = :codLogin");
  $query->bindParam(':codLogin', $codLoginFijo, PDO::PARAM_INT); // Usar un parámetro nombrado
  $query->execute();

  // Verificar si se encontraron resultados
  if ($query->rowCount() > 0) {
    // Obtener los datos
    $userData = $query->fetch(PDO::FETCH_ASSOC);

    // Almacenar datos en variables
    $codLogin = htmlspecialchars($userData['codLogin']);
    $nombre = htmlspecialchars($userData['nombre']);
    $apellidos = htmlspecialchars($userData['apellidos']);
    $email = htmlspecialchars($userData['email']);
  } else {
    throw new Exception("No se encontraron datos para el usuario.");
  }
} catch (PDOException $e) {
  // Manejo de errores de base de datos
  echo "Error en la conexión: " . htmlspecialchars($e->getMessage());
  exit();
} catch (Exception $e) {
  // Manejo de errores generales
  echo "Error: " . htmlspecialchars($e->getMessage());
  exit();
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
  <link rel="stylesheet" href="default_user.css">
  <link href="Logo.ico" rel="icon">
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
        <img src="Logo.ico" alt="logo" />
      </div>

      <div class="user-info">
        <img src="https://cdn-icons-png.flaticon.com/512/7816/7816916.png" alt="user" />
        <p><?php echo isset($nombresPersonal) ? $nombresPersonal . ' ' . $apellidoPaterno . ' ' . $apellidoMaterno : ''; ?>
        </p>
      </div>
      <ul>
        <li class="nav-item active">
          <a href="../Pages_Dash/user.php">
            <i class="fa fa-user nav-icon"></i>
            <span class="nav-text">Cuenta</span>
          </a>
        </li>

        <li class="nav-item">
          <a href="../index.php">
            <i class="fa-solid fa-table nav-icon"></i>
            <span class="nav-text">Tablero</span>
          </a>
        </li>

        <li class="nav-item">
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
            <div class="profile-container">
              <img src="https://cdn-icons-png.flaticon.com/512/7816/7816916.png" alt="user" />
              <input type="hidden" name="codLogin" value="<?= isset($id) ? $id : '' ?>">
              <?php
              if ($result->num_rows > 0) {
              ?>
                <div>
                  <?php
                  echo "<p><strong>Tipo Personal:</strong>" . $tipoPersonal . "</p>";
                  echo "<p><strong>Nombres:</strong>" . $nombresPersonal . "</p>";
                  echo "<p><strong>Apellido Paterno:</strong>" . $apellidoPaterno . "</p>";
                  echo "<p><strong>Apellido Materno:</strong>" . $apellidoMaterno . "</p>";
                  ?>
                </div>
            </div>
            <div class="data-container">
              <div class="data-column">
                <?php
                echo "<div><span><strong>Tipo de Documento:</strong></span><p>" . $tipoDocumento . "</p></div>";
                echo "<div><span><strong>Teléfono:</strong></span><p> " . $telefono . "</p></div>";
                echo "<div><span><strong>Celular:</strong></span><p> " . $celular . "</p></div>";
                echo "<div><span><strong>Especialidad:</strong></span><p> " . $nomEsp . "</p></div>";
                ?>
              </div>
              <div class="data-column">
                <?php
                echo "<div><span><strong>Número de Documento:</strong></span><p>" . $nroDocumento . "</p></div>";
                echo "<div><span><strong>Correo JP:</strong></span><p> " . $correoJP . "</p></div>";
                echo "<div><span><strong>Dirección:</strong></span><p> " . $direccion . "</p></div>";
                ?>
              </div>
              <div class="data-column">
                <?php
                echo "<div><span><strong>Estado Personal:</strong></span><p> " . $estadoPersonal . "</p></div>";
                echo "<div><span><strong>Correo Personal:</strong></span><p> " . $correoPersonal . "</p></div>";
                echo "<div><span><strong>Código Plaza:</strong></span><p> " . $codigoPlaza . "</p></div>";
                ?>
              </div>
            </div>
          <?php
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
              <img src="https://cdn-icons-png.flaticon.com/512/7816/7816916.png" alt="User Icon" />
              <p>Usuario <span><a target="_blank"
                  href="https://github.com/Alonso-dev651/EFSRT">Developer</a></span></p>
            </div>
            <small>1 hour ago</small>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>

</html>