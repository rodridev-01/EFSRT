<?php
session_start();
include 'php/nuevoFut.php';
$codLogin = $_SESSION['codLogin'];
include 'php/db_conexion.php';

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


$query = "SELECT apPaterno, apMaterno, nombres, tipoDocu, nroDocu, codModular, telf, celular, correoJP, correoPersonal, direccion, anioIngreso, anioEgreso FROM solicitante WHERE codLogin = ?";
$stmt = mysqli_prepare($conexion, $query);
mysqli_stmt_bind_param($stmt, 'i', $codLogin);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $apPaterno, $apMaterno, $nombres, $tipoDocu, $nroDocu, $codModular, $telf, $celular, $correoJP, $correoPersonal, $direccion, $anioIngreso, $anioEgreso);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
  <link rel="stylesheet" href="../style.css">
  <link href="../Pages_Dash/Logo.ico" rel="icon">
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
        <img src="../Pages_Dash/Logo.ico" alt="logo" />
      </div>

      <div class="user-info">
        <img src="https://cdn-icons-png.flaticon.com/512/7816/7816916.png" alt="user" />
        <p><?php echo $nombres . ' ' . $apPaterno . ' ' . $apMaterno; ?></p>
      </div>

      <ul>
        <li class="nav-item">
          <a href="../Pages_Dash/user.php">
            <i class="fa fa-user nav-icon"></i>
            <span class="nav-text">Cuenta</span>
          </a>
        </li>

        <li class="nav-item">
          <a href="../../dashboardCoordinador/home.php">
            <i class="fa-solid fa-table nav-icon"></i>
            <span class="nav-text">Tablero</span>
          </a>
        </li>

        <li class="nav-item active">
          <a href="formularioFUT.php">
            <i class="fa fa-arrow-trend-up nav-icon"></i>
            <span class="nav-text">Tramite</span>
          </a>
        </li>

        <li class="nav-item">
          <a href="../Estado_fut/estado.php">
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
      </div>

      <div class="upcoming-events">
      <h1>FORMULARIO FUT</h1>
      <form class="form-solicitud" method="POST" action="proceso_fut.php">
    <div class="input-row">
        <div>
            <p>Fecha: <span id="current-date"></span></p>
            <p>Hora: <span id="current-time"></span></p>
        </div>
    </div>

    <div class="input-row">
            <div class="form-group">
                <label for="apPaterno">Apellido Paterno</label>
                <input type="text" id="apPaterno" name="apPaterno" value="<?php echo $apPaterno; ?>" required>
            </div>

            <div class="form-group">
                <label for="apMaterno">Apellido Materno</label>
                <input type="text" id="apMaterno" name="apMaterno" value="<?php echo $apMaterno; ?>" required>
            </div>

            <div class="form-group">
                <label for="nombres">Nombres</label>
                <input type="text" id="nombres" name="nombres" value="<?php echo $nombres; ?>" required>
            </div>
        </div>

    <div class="input-row">
            <div class="form-group">
                <label for="tipoDocu">Tipo de documento</label>
                <select id="tipoDocu" name="tipoDocu" required>
                    <option value="DNI" <?php echo ($tipoDocu == 'DNI') ? 'selected' : ''; ?>>DNI</option>
                    <option value="CEX" <?php echo ($tipoDocu == 'CEX') ? 'selected' : ''; ?>>CEX</option>
                    <option value="PAS" <?php echo ($tipoDocu == 'PAS') ? 'selected' : ''; ?>>PAS</option>
                </select>
            </div>

            <div class="form-group">
                <label for="nroDocu">Nro Documento</label>
                <input type="text" id="nroDocu" name="nroDocu" value="<?php echo $nroDocu; ?>" required>
            </div>

            <div class="form-group">
                <label for="codModular">Código Modular</label>
                <input type="text" id="codModular" name="codModular" value="<?php echo $codModular; ?>">
            </div>
        </div>

        <div class="input-row">
            <div class="form-group">
                <label for="telf">Teléfono</label>
                <input type="text" id="telf" name="telf" value="<?php echo $telf; ?>">
            </div>

            <div class="form-group">
                <label for="celular">Celular</label>
                <input type="text" id="celular" name="celular" value="<?php echo $celular; ?>">
            </div>
        </div>
        <div class="input-row">
            <div class="form-group">
                <label for="correoJP">Correo Institucional:</label>
                <input type="email" id="correoJP" name="correoJP" value="<?php echo $correoJP; ?>" required>
            </div>

            <div class="form-group">
                <label for="correoPersonal">Correo Personal</label>
                <input type="email" id="correoPersonal" name="correoPersonal" value="<?php echo $correoPersonal; ?>" required>
            </div>
        </div>

        <div class="input-row">
        <div class="form-group">
            <label for="direccion">Dirección:</label>
            <input type="text" id="direccion" name="direccion" value="<?php echo $direccion; ?>">
        </div>
        </div>

        <div class="input-row">      
            <div class="form-group">
                <label for="anioIngreso">Año Ingreso</label>
                <input type="number" id="anioIngreso" name="anioIngreso" value="<?php echo $anioIngreso; ?>" required>
            </div>

            <div class="form-group">
                <label for="anioEgreso">Año Egreso (Opcional)</label>
                <input type="number" id="anioEgreso" name="anioEgreso" value="<?php echo $anioEgreso; ?>">
            </div>
        </div>
        
        <div class="input-row">
        <div class="tipoTramite">
            <div class="form-group">
                <label for="tipoTramite">Tipo de Tramite</label>
                <select id="tipoTramite" name="tipoTramite" required>
                    <option value="" disabled selected>Tramites</option>
                    <?php
                    include './php/mostrar_tipoTramites.php';
                    ?>
                </select>
            </div>
        </div>
    </div>

        <div class="input-row">  
        <div class="form-group">
        <label for="solicitud">Descripción de Solicitud</label>
        <textarea class="solicitud" name="solicitud" id="solicitud"></textarea>
    </div>
    </div>
        

    <!-- Botones al final -->
    <div class="input-row buttons-row">
        <button type="button" class="btn-cancel" onclick="window.location.href='../home.php'">Cancelar trámite</button>
        <button type="submit" class="btn-submit">Enviar Solicitud</button>
    </div>
</form>

    <script src="./js/cargarDatos.js"></script>
    <script src="./js/fechaHora.js"></script>
      </div>
    </div>
  </section>
</body>
</html>
