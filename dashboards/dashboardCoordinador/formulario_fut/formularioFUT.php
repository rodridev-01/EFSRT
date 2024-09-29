<?php
session_start();
include 'php/nuevoFut.php';
$codLogin = $_SESSION['codLogin'];
include 'php/db_conexion.php';

// Consulta para obtener los datos del solicitante
$query = "SELECT apPaterno, apMaterno, nombres, tipoDocu, nroDocu, codModular, telf, celular, correoJP, correoPersonal, direccion, anioIngreso, anioEgreso FROM solicitante WHERE codLogin = ?";
$stmt = mysqli_prepare($conexion, $query);
mysqli_stmt_bind_param($stmt, 'i', $codLogin);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $apPaterno, $apMaterno, $nombres, $tipoDocu, $nroDocu, $codModular, $telf, $celular, $correoJP, $correoPersonal, $direccion, $anioIngreso, $anioEgreso);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completa tu Solicitud</title>
    <link rel="stylesheet" href="style/styleFut.css">
</head>

<body>

    <h1>FORMULARIO FUT</h1>
    <form class="form-solicitud" method="POST" action="proceso_fut.php">
    <div class="input-row" style="margin-bottom: 10px">
            <div>
                <p>Fecha: <span id="current-date"></span></p>
                <p>Hora: <span id="current-time"></span></p>
            </div>
             <button type="button" onclick="window.location.href='../home.php'">Cancelar trámite</button>
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

        <div class="form-group">
            <label for="direccion">Dirección:</label>
            <input type="text" id="direccion" name="direccion" value="<?php echo $direccion; ?>">
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

    <div class="form-group">
        <label for="solicitud">Descripción de Solicitud</label>
        <textarea class="solicitud" name="solicitud" id="solicitud"></textarea>
    </div>

    <button type="submit">Enviar Solicitud</button>
</form>


    <script src="./js/cargarDatos.js"></script>
    <script src="./js/fechaHora.js"></script>

</body>

</html>
