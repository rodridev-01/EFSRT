<?php
session_start();
include 'php/nuevoFut.php';
$nroFut = $_POST['nroFut']; // Obtener nroFut del formulario anterior
include 'php/db_conexion.php';

// Consulta para obtener los datos del solicitante y el tipo de trámite basado en nroFut
$query = "SELECT s.apPaterno, s.apMaterno, s.nombres, s.tipoDocu, s.nroDocu, s.codModular, s.telf, s.celular, s.correoJP, s.correoPersonal, s.direccion, s.anioIngreso, s.anioEgreso, f.codTT, f.solicito, f.descripcion, f.comentario, f.estado, f.archivo_pdf
          FROM solicitante s
          INNER JOIN fut f ON s.codLogin = f.codSoli
          WHERE f.nroFut = ?";
$stmt = mysqli_prepare($conexion, $query);
mysqli_stmt_bind_param($stmt, 'i', $nroFut);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $apPaterno, $apMaterno, $nombres, $tipoDocu, $nroDocu, $codModular, $telf, $celular, $correoJP, $correoPersonal, $direccion, $anioIngreso, $anioEgreso, $codTTSeleccionado, $solicito, $descripcion, $comentario, $estado, $archivo_pdf);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completa tu Solicitud</title>
    <link rel="stylesheet" href="style/styleFutDocente.css">
</head>

<body>

    <h1>FORMULARIO FUT</h1>

    <div class="form-container"> <!-- Contenedor para ambos formularios -->

        <div class="form-solicitud">
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
                    <input type="text" id="apPaterno" name="apPaterno" value="<?php echo $apPaterno; ?>" disabled>
                </div>

                <div class="form-group">
                    <label for="apMaterno">Apellido Materno</label>
                    <input type="text" id="apMaterno" name="apMaterno" value="<?php echo $apMaterno; ?>" disabled>
                </div>

                <div class="form-group">
                    <label for="nombres">Nombres</label>
                    <input type="text" id="nombres" name="nombres" value="<?php echo $nombres; ?>" disabled>
                </div>
            </div>

            <div class="input-row">
                <div class="form-group">
                    <label for="tipoDocu">Tipo de documento</label>
                    <select id="tipoDocu" name="tipoDocu" disabled>
                        <option value="DNI" <?php echo ($tipoDocu == 'DNI') ? 'selected' : ''; ?>>DNI</option>
                        <option value="CEX" <?php echo ($tipoDocu == 'CEX') ? 'selected' : ''; ?>>CEX</option>
                        <option value="PAS" <?php echo ($tipoDocu == 'PAS') ? 'selected' : ''; ?>>PAS</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="nroDocu">Nro Documento</label>
                    <input type="text" id="nroDocu" name="nroDocu" value="<?php echo $nroDocu; ?>" disabled>
                </div>

                <div class="form-group">
                    <label for="codModular">Código Modular</label>
                    <input type="text" id="codModular" name="codModular" value="<?php echo $codModular; ?>" disabled>
                </div>
            </div>

            <div class="input-row">
                <div class="form-group">
                    <label for="telf">Teléfono</label>
                    <input type="text" id="telf" name="telf" value="<?php echo $telf; ?>" disabled>
                </div>

                <div class="form-group">
                    <label for="celular">Celular</label>
                    <input type="text" id="celular" name="celular" value="<?php echo $celular; ?>" disabled>
                </div>
            </div>

            <div class="input-row">
                <div class="form-group">
                    <label for="correoJP">Correo Institucional</label>
                    <input type="email" id="correoJP" name="correoJP" value="<?php echo $correoJP; ?>" disabled>
                </div>

                <div class="form-group">
                    <label for="correoPersonal">Correo Personal</label>
                    <input type="email" id="correoPersonal" name="correoPersonal" value="<?php echo $correoPersonal; ?>" disabled>
                </div>
            </div>

            <div class="input-row">
                <div class="form-group">
                    <label for="direccion">Dirección</label>
                    <input type="text" id="direccion" name="direccion" value="<?php echo $direccion; ?>" disabled>
                </div>

                <div class="form-group">
                    <label for="anioIngreso">Año Ingreso</label>
                    <input type="number" id="anioIngreso" name="anioIngreso" value="<?php echo $anioIngreso; ?>" disabled>
                </div>

                <div class="form-group">
                    <label for="anioEgreso">Año Egreso (Opcional)</label>
                    <input type="number" id="anioEgreso" name="anioEgreso" value="<?php echo $anioEgreso; ?>" disabled>
                </div>
            </div>

            <div class="input-row">
                <div class="form-group">
                    <label for="tipoTramite">Tipo de Tramite</label>
                    <select id="tipoTramite" name="tipoTramite" disabled>
                        <option value="" disabled>Tramites</option>
                        <?php include 'php/mostrar_tipoTramites.php'; ?>
                    </select>
                </div>
            </div>
            <div class="input-row">
                <div class="form-group">
                    <label for="solicito">Solicitud</label>
                    <input type="text" id="solicito" name="solicito" value="<?php echo $solicito; ?>" disabled>
                </div>
            </div>
            <div class="input-row">
                <div class="form-group">
                    <label for="descripcion">Descripción de la Solicitud</label>
                    <textarea style="width: 200%; resize: none;" id="descripcion" name="descripcion" disabled><?php echo $descripcion; ?></textarea>
                </div>
            </div>
        </div>
        
        <!-- Formulario para comentarios -->
        <form class="form-solicitud" action="procesar_docente.php" method="POST" id="miFormulario" enctype="multipart/form-data">
            <h2>Comentarios y Estado</h2>
            <div class="form-group">
                <label for="comentario">Comentario</label>
                <textarea style="resize: vertical;" id="comentario" name="comentario" required><?php echo $comentario; ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="estado">Estado</label>
                <select id="estado" name="estado" required>
                    <option value="H" <?php echo ($estado == 'H') ? 'selected' : ''; ?>>HABILITADO</option>
                    <option value="A" <?php echo ($estado == 'A') ? 'selected' : ''; ?>>APROBADO</option>
                    <option value="D" <?php echo ($estado == 'D') ? 'selected' : ''; ?>>DESAPROBADO</option>
                </select>
                <input type="hidden" name="nroFut" value="<?php echo $nroFut; ?>">
            </div>
        
            <div class="form-group">
                <label for="documento">Agregar Documento</label>
                
                <?php if (!empty($archivo_pdf)): ?>
                    <p>
                        <a href="uploads/<?php echo $archivo_pdf; ?>" target="_blank">Abrir archivo existente</a>
                    </p>
                    <p>
                        <label for="nuevoDocumento">Subir nuevo documento (opcional)</label>
                        <input type="file" id="nuevoDocumento" name="nuevoDocumento">
                    </p>
                <?php else: ?>
                    <input type="file" id="nuevoDocumento" name="nuevoDocumento" required>
                <?php endif; ?>
                               <?php
                echo 'Tamaño máximo del archivo: ' . ini_get('upload_max_filesize');
                ?>
            </div>

            <button type="submit">Enviar</button>
        </form>
    </div>
    
    <script>
        // Función para mostrar la fecha y hora actual
        function updateDateTime() {
            const now = new Date();
            document.getElementById('current-date').textContent = now.toLocaleDateString('es-PE');
            document.getElementById('current-time').textContent = now.toLocaleTimeString('es-PE');
        }
        setInterval(updateDateTime, 1000);
    </script>
    
    
    
    <script>
    //Funcion para indicar maximo tamaño de archivo pdf
    document.getElementById('miFormulario').addEventListener('submit', function(event) {
        // Tamaño máximo en bytes (ejemplo: 2MB)
        const maxSize = 2 * 1024 * 1024; // 2MB
        const fileInput = document.getElementById('nuevoDocumento');
        
        // Verifica si se seleccionó un archivo
        if (fileInput.files.length > 0) {
            const file = fileInput.files[0];
            if (file.size > maxSize) {
                // Prevenir el envío del formulario
                event.preventDefault();
                alert('El archivo es demasiado grande. El tamaño máximo permitido es 2MB.');
            }
        }
    });
</script>

</body>
</html>
