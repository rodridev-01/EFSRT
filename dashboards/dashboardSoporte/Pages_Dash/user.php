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
        <img
          src="Logo.ico"
          alt="logo" />
      </div>

      <div class="user-info">
        <img src="https://cdn-icons-png.flaticon.com/512/7816/7816916.png" alt="user" />
        <p>Soporte</p>
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
          <a href="../formulario_fut/formularioFUT.php">
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
        <div>
            <div class="user-container">
                <div class="profile-container">
                    <img src="https://cdn-icons-png.flaticon.com/512/7816/7816916.png" alt="user" />
                   <?php
                        // Código de conexión
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
                        
                        // Consulta para obtener los datos de la tabla 'solicitante'
                        $sql = "SELECT nombres, apPaterno, apMaterno, tipoDocu, nroDocu, codModular, telf, celular, correoJP, correoPersonal, direccion, codDis, codEsp, anioIngreso, anioEgreso FROM solicitante WHERE codLogin = 1";
                        $resultado = $conn->query($sql);
                        
                        if ($resultado->num_rows > 0) {
                            // Mostrar los datos de la tabla
                            while ($fila = $resultado->fetch_assoc()) {
                                echo "<p>Nombres: " . $fila['nombres'] . "</p>";
                                echo "<p>Apellido Paterno: " . $fila['apPaterno'] . "</p>";
                                echo "<p>Apellido Materno: " . $fila['apMaterno'] . "</p>";
                                echo "<p>Tipo de Documento: " . $fila['tipoDocu'] . "</p>";
                                echo "<p>Número de Documento: " . $fila['nroDocu'] . "</p>";
                                echo "<p>Código Modular: " . $fila['codModular'] . "</p>";
                                echo "<p>Teléfono: " . $fila['telf'] . "</p>";
                                echo "<p>Celular: " . $fila['celular'] . "</p>";
                                echo "<p>Correo JP: " . $fila['correoJP'] . "</p>";
                                echo "<p>Correo Personal: " . $fila['correoPersonal'] . "</p>";
                                echo "<p>Dirección: " . $fila['direccion'] . "</p>";
                                echo "<p>Código de Distrito: " . $fila['codDis'] . "</p>";
                                echo "<p>Código de Especialidad: " . $fila['codEsp'] . "</p>";
                                echo "<p>Año de Ingreso: " . $fila['anioIngreso'] . "</p>";
                                echo "<p>Año de Egreso: " . $fila['anioEgreso'] . "</p>";
                            }
                        } else {
                            echo "No se encontraron datos";
                        }
                        
                        // Cerrar la conexión
                        $conn->close();
                        ?>
                </div>
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