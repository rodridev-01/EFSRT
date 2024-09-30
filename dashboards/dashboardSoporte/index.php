<?php
include ("php/db_conexion.php");

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
} else {
    echo "No se encontraron datos para el codLogin proporcionado.";
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
    <link href="Icons_Dash/Logo.ico" rel="icon">
    <script defer src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
    <script defer src="main.js"></script>

    <!-- añadiendo fontawesome para icono editar -->
    <script src="https://kit.fontawesome.com/a683fc1d22.js" crossorigin="anonymous"></script>

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
                <!-- <p><?php //echo isset($nombresPersonal) ? $nombresPersonal . ' ' . $apellidoPaterno . ' ' . $apellidoMaterno : ''; ?></p> -->
            </div>
            <ul>
                <!-- <li class="nav-item">
                    <a href="Pages_Dash/user.php">
                        <i class="fa fa-user nav-icon"></i>
                        <span class="nav-text">Cuenta</span>
                    </a>
                </li> -->

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
                <div class="fut-container">
                <!-- Mostrar las tarjetas con datos desde la base de datos -->
                <form action="" class="card-container">
                    <?php
                    include "php/db_conexion.php";
                    $sql = $conexion->query("SELECT * FROM personal");
                    while ($datos = $sql->fetch_object()) {
                    ?>
                    <div class="fut-card"> <!-- Usando la clase fut-card para las tarjetas -->
                    <div class="fut-details"> <!-- Clase para los detalles de la tarjeta -->
                        <h3><?= $datos->nombres ?> <?= $datos->apPaterno ?> <?= $datos->apMaterno ?></h3>
                        <p><strong>Nro Doc:</strong> <?= $datos->nroDocu ?></p>
                        <p><strong>Celular:</strong> <?= $datos->celular ?></p>
                        <p><strong>Correo Institucional:</strong> <?= $datos->correoJP ?></p>
                        <p><strong>Correo Personal:</strong> <?= $datos->correoPersonal ?></p>
                        <p><strong>Estado:</strong> <?= $datos->estado ?></p>
                        <p><strong>Tipo Personal:</strong> <?= $datos->tipoPer ?></p>
                    </div>
                    <div class="fut-form"> <!-- Clase para alinear el botón -->
                        <a href="modificar_personal.php?id=<?= $datos->codLogin ?>" class="fut-button">
                        <i class="fa-solid fa-user-pen"></i> Editar
                        </a>
                    </div>
                    </div>
                    <?php
                    }
                    ?>
                </form>

            <!-- Botón para registrar nuevo personal -->
            <div class="fut-navigation">
                <a href="registrar_personal.php" class="fut-nav-button">
                <i class="fa-solid fa-address-card"></i> Registrar Personal
                </a>
            </div>
            </div>

        </div>

        <!-- Contenido lado derecho -->

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