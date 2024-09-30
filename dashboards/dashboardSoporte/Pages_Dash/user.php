<?php
include ("../php/db_conexion.php");

// Usar el valor fijo 74
$codLoginFijo = 74;

// Consultar los datos del registro para el codLogin fijo
$sql = "SELECT * FROM personal WHERE codLogin = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $codLoginFijo);  
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $personal = $result->fetch_assoc();

    $apellidoPaterno = $personal['apPaterno'];
    $apellidoMaterno = $personal['apMaterno'];
    $nombresPersonal = $personal['nombres'];
    $tipoDocumento = $personal['tipoDocu'];
    $nroDocumento = $personal['nroDocu'];
    $telefono = $personal['telf'];
    $celular = $personal['celular'];
    $correoJP = $personal['correoJP'];
    $correoPersonal = $personal['correoPersonal'];
    $direccion = $personal['direccion'];
    $codigoPlaza = $personal['codigoPlaza'];
    $estadoPersonal = $personal['estado'];
    $tipoPersonal = $personal['tipoPer'];
} else {
    echo "No se encontraron datos para el codLogin proporcionado.";
}

$conexion->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link rel="stylesheet" href="user.css">
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
                <a href="https://grupo1.live-ra.com/pruebasxamp/">
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
                <div class="interaction-control-mobile interactions">
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
            </div>

            <div class="left-content">
                <div class="user-profile">
                    <h1>User profile</h1>
                    <div class="user-container">
                        <div class="profile-container">
                            <img src="https://cdn-icons-png.flaticon.com/512/7816/7816916.png" alt="user" />
                            <input type="hidden" name="codLogin" value="<?= isset($id) ? $id : '' ?>">
                            <?php
                if ($result->num_rows > 0) {

                    echo "<p><strong>Tipo Personal:</strong> " . $tipoPersonal . "</p>";
                    echo "<p><strong>Nombres:</strong> " . $nombresPersonal . "</p>";
                    echo "<p><strong>Apellido Paterno:</strong> " . $apellidoPaterno . "</p>";
                    echo "<p><strong>Apellido Materno:</strong> " . $apellidoMaterno . "</p>";
                    echo "<p><strong>Tipo de Documento:</strong> " . $tipoDocumento . "</p>";
                    echo "<p><strong>Número de Documento:</strong> " . $nroDocumento . "</p>";
                    echo "<p><strong>Teléfono:</strong> " . $telefono . "</p>";
                    echo "<p><strong>Celular:</strong> " . $celular . "</p>";
                    echo "<p><strong>Correo JP:</strong> " . $correoJP . "</p>";
                    echo "<p><strong>Correo Personal:</strong> " . $correoPersonal . "</p>";
                    echo "<p><strong>Dirección:</strong> " . $direccion . "</p>";
                    echo "<p><strong>Código Plaza:</strong> " . $codigoPlaza . "</p>";
                    echo "<p><strong>Estado Personal:</strong> " . $estadoPersonal . "</p>";
                    
                } else {
                    echo "<p>No se encontraron datos para este usuario.</p>";
                }
                
                ?>
                        </div>
                    </div>
                </div>
            </div>
            <!--
      <div class="upcoming-events">
        <h1>Tablero</h1>
        <div class="event-container">
          <div class="card event-card">
            <div class="event-header">
              <img
                src="https://comers.com.pe/wp-content/uploads/classified-listing/2024/01/servicio-tecnico-pc-san-isidro.png"
                alt="" />
              <p>CI 1° Módulo</p>
              <i class="bx bx-heart like-btn"></i>
            </div>
            <div class="event-content">
              <h2>Mantenimiento de Equipos de Cómputo</h2>
              <p>Practicas 1er Modulo</p>
            </div>
            <div class="event-footer">
              <p style="background-color: #e48e2c">Pendiente</p>
              <div class="btn-group">
                <button>Consultar</button>
                <div class="share">
                  <button class="share-btn">
                    <i class="fa-solid fa-share"></i>
                  </button>
                  <ul class="popup">
                    <li>
                      <a href="#" style="color: rgb(79, 153, 213)"><i class="bx bxl-facebook"></i></a>
                    </li>
                    <li>
                      <a href="#" style="color: rgb(34, 173, 34)"><i class="bx bxl-whatsapp"></i></a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>

          <div class="card event-card">
            <div class="event-header">
              <img
                src="https://www.microtech.es/hubfs/37228729_m.jpg"
                alt="" />
              <p>CI 2° Módulo</p>
              <i class="bx bx-heart like-btn"></i>
            </div>
            <div class="event-content">
              <h2>Base de Datos</h2>
              <p>Practicas 2do Módulo</p>
            </div>
            <div class="event-footer">
              <p style="background-color: #4a920f">Completo</p>
              <div class="btn-group">
                <button>Consultar</button>
                <div class="share">
                  <button class="share-btn">
                    <i class="fa-solid fa-share"></i>
                  </button>
                  <ul class="popup">
                    <li>
                      <a href="#" style="color: rgb(79, 153, 213)"><i class="bx bxl-facebook"></i></a>
                    </li>
                    <li>
                      <a href="#" style="color: rgb(34, 173, 34)"><i class="bx bxl-whatsapp"></i></a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="reviews">
        <h1>Evaluación del Docente</h1>
        <div class="review-container">
          <div class="card review-card">
            <h2>Raul Salazar (Prácticas 1° Módulo)</h2>
            <div class="ratings">
              <i class="bx bxs-star"></i>
              <i class="bx bxs-star"></i>
              <i class="bx bxs-star"></i>
              <i class="bx bx-star"></i>
              <i class="bx bx-star"></i>
            </div>
            <p>
              El estudiante mostró buenas habilidades, pero su informe requiere más claridad y mejor organización.
            </p>
          </div>

          <div class="card review-card">
            <h2>Daniel Ramos (Prácticas 2° Módulo)</h2>
            <div class="ratings">
              <i class="bx bxs-star"></i>
              <i class="bx bxs-star"></i>
              <i class="bx bxs-star"></i>
              <i class="bx bxs-star"></i>
              <i class="bx bxs-star-half"></i>
            </div>
            <p>
              El estudiante mostró buenas habilidades; el informe está bien y cumple con los requisitos.
            </p>
          </div>
        </div>
      </div>
      !-->
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
                            <p>Usuario <span><a href="#">Developer</a></span></p>
                        </div>
                        <small>1 hour ago</small>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>