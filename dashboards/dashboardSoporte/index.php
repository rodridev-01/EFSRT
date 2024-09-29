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

    <!-- añadiendo fontawesome para icono editar -->
    <script src="https://kit.fontawesome.com/a683fc1d22.js" crossorigin="anonymous"></script>

    <!-- añadiendo bootstrap para estilos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

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
                <p>Soporte</p>
            </div>
            <ul>
                <li class="nav-item">
                    <a href="Pages_Dash/user.php">
                        <i class="fa fa-user nav-icon"></i>
                        <span class="nav-text">Cuenta</span>
                    </a>
                </li>

                <li class="nav-item active">
                    <a href="index.php">
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

            <!-- Inicio de la vista de los registros -->
            <div class="d-flex justify-content-center align-items-center">
                <h1>REGISTROS DEL PERSONAL</h1>
            </div>
            <hr>


            <div class="">
                <table class="table">
                    <thead class="bg">
                        <tr>

                            <th scope="col">Apellido Paterno</th>
                            <th scope="col">Apellido Materno</th>
                            <th scope="col">Nombres</th>
                            <th scope="col">Nro Doc</th>
                            <th scope="col">Celular</th>
                            <th scope="col">Correo JP</th>
                            <th scope="col">Correo Personal</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Tipo Personal</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
              include "php/db_conexion.php";
              $sql = $conexion -> query("Select * from personal");
              while ($datos = $sql -> fetch_object()) {
                
            ?>
                        <tr>
                            <td><?= $datos -> apPaterno?></td>
                            <td><?= $datos -> apMaterno?></td>
                            <td><?= $datos -> nombres?></td>
                            <td><?= $datos -> nroDocu?></td>
                            <td><?= $datos -> celular?></td>
                            <td><?= $datos -> correoJP?></td>
                            <td><?= $datos -> correoPersonal?></td>
                            <td><?= $datos -> estado?></td>
                            <td><?= $datos -> tipoPer?></td>
                             <!-- 
                            <td>
                                <a href="" class="btn btn-small btn-warning"><i
                                        class="fa-solid fa-user-pen"> Editar</i></a>
                            </td>
                            -->
                        </tr>
                        <?php
              }
            ?>

                    </tbody>
                </table>
                <a href="prueba.php" class="btn btn-small btn-success"><i
                        class="fa-solid fa-address-card"></i>
                    Registrar Personal</a>
            </div>




            <!-- <div class="search-and-check">
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
      </div> -->
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