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



    <link rel="stylesheet" href="css/styles.css">

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

            <?php
                include "php/db_conexion.php";
            ?>
            <!-- <pre>
                -Falta validaciones en varios campos.
                -NO REGISTRAR el mismo CORREOJP O DARA ERROR.
                -CORREO JP SE CONSIDERA USUARIO POR EL MOMENTO.
                -TODOS LOS USUARIOS REGISTRADOS DEBEN ESTAR EN LA TABLA LOGIN
                -SE OBTIENE EL VALOR MAS ALTO DEL codLogin QUE EXISTA EN LA TABLA
                LOGIN Y SE LE SUMA 1, YA QUE NO Esta
                COMO CAMPO AUTO INCREMENT. (GARANTIZA SER ÚNICO)
            </pre> -->

            <form id="personalForm" method="POST" action="php/registrar_personal.php">
                <label for="tipoPersonal">Tipo de Personal</label>
                <select name="tipoPersonal" id="tipoPersonal" required>
                    <option value="" selected disabled>--Seleccione Personal--</option>
                    <option value="DOCENTE">Docente</option>
                    <option value="COORDINADOR">Coordinador</option>
                    <option value="DIRECTIVO">Directivo</option>
                </select>

                <br><br>

                <label for="apellidoPaterno">Apellido Paterno</label>
                <input type="text" name="apellidoPaterno" id="apellidoPaterno" required disabled maxlength="30"
                    oninput="soloLetras(event)">

                <br><br>

                <label for="apellidoMaterno">Apellido Materno</label>
                <input type="text" name="apellidoMaterno" id="apellidoMaterno" required disabled maxlength="30"
                    oninput="soloLetras(event)">

                <br><br>

                <label for="nombresPersonal">Nombres</label>
                <input type="text" name="nombresPersonal" id="nombresPersonal" required disabled maxlength="40"
                    oninput="soloLetras(event)">

                <br><br>

                <label for="tipoDocumento">Tipo de Documento</label>
                <select name="tipoDocumento" id="tipoDocumento" required disabled>
                    <option value="" selected disabled>--Seleccione un Tipo de Documento--</option>
                    <option value="DNI">DNI</option>
                    <option value="CEX">CEX</option>
                    <option value="PAS">PAS</option>
                </select>

                <br><br>

                <label for="nroDocumento">Número de Documento</label>
                <input type="text" name="nroDocumento" id="nroDocumento" required disabled maxlength="15">

                <br><br>

                <label for="telefono">Teléfono Fijo</label>
                <input type="tel" name="telefono" id="telefono" required disabled maxlength="30"
                    oninput="soloNumeros(event)">

                <br><br>

                <label for="celular">Celular de Contacto</label>
                <input type="tel" name="celular" id="celular" required disabled maxlength="9"
                    oninput="soloNumeros(event)">

                <br><br>

                <label for="correoJosePardo">Correo Electrónico Institucional</label>
                <input type="email" name="correoJosePardo" id="correoJosePardo" placeholder="UNICO" required disabled
                    maxlength="80">

                <br><br>

                <label for="correoPersonal">Correo Electrónico Personal</label>
                <input type="email" name="correoPersonal" id="correoPersonal" required disabled maxlength="80">

                <br><br>

                <label for="departamento">Departamento:</label>
                <select name="departamento" id="departamento" required disabled>
                    <option value="" selected disabled>--Seleccione un departamento--</option>
                </select>


                <label for="provincia">Provincia:</label>
                <select name="provincia" id="provincia" required disabled>
                    <option value="" selected disabled>--Seleccione una provincia--</option>
                </select>

                <label for="distrito">Distrito:</label>
                <select name="distrito" id="distrito" required disabled>
                    <option value="" selected disabled>--Seleccione un distrito--</option>
                </select>

                <br><br>

                <label for="direccion">Escribe la dirección</label>
                <input type="text" name="direccion" id="direccion" required disabled maxlength="120">

                <br><br>

                <label for="codigoEspecialidad">Especialidad</label>
                <select name="codigoEspecialidad" id="codigoEspecialidad" required disabled>
                    <option value="" selected disabled>--Seleccione Especialidad--</option>
                    <?php include 'php/mostrar_especialidad.php'?>
                </select>

                <br><br>

                <label for="estable">Estable</label>
                <select name="estable" id="estable" required disabled>
                    <option value="" selected disabled>--Seleccione Condición--</option>
                    <option value="S">Nombrado</option>
                    <option value="N">Contratado</option>
                </select>

                <br><br>

                <label for="anioNombramiento">Año de Nombramiento</label>
                <input type="number" name="anioNombramiento" id="anioNombramiento" placeholder="YYYY" required disabled>

                <br><br>

                <label for="anioCese">Año de Cese</label>
                <input type="number" name="anioCese" id="anioCese" placeholder="YYYY" required disabled>

                <br><br>

                <label for="codigoPlaza">Código de plaza</label>
                <input type="text" name="codigoPlaza" id="codigoPlaza" required disabled maxlength="20">

                <br><br>

                <label for="anioContrato">Año de Ingreso</label>
                <input type="number" name="anioContrato" id="anioContrato" placeholder="YYYY" required disabled>

                <br><br>

                <label for="inicioContrato">Inicio de Contrato</label>
                <input type="date" name="inicioContrato" id="inicioContrato" required disabled>

                <br><br>

                <label for="finContrato">Fin de Contrato</label>
                <input type="date" name="finContrato" id="finContrato" required disabled>

                <br><br>

                <label for="estadoPersonal">Estado</label>
                <select name="estadoPersonal" id="estadoPersonal" required disabled>
                    <option value="" selected disabled>--Seleccione Estado Personal--</option>
                    <option value="H">Habilitado</option>
                    <option value="B">Baja</option>
                </select>

                <br><br>

                <button type="submit">Agregar</button>
            </form>


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

    <script src="js/ubigeo.js"></script>
    <script src="js/formulario.js"></script>

    <!-- añadiendo para aplicar bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>