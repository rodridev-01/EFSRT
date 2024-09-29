<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include '../formulario_fut/php/db_conexion.php';

// Consulta para obtener los docentes desde la columna tipoLogin
$sqlDocentes = "SELECT codLogin, usuLogin FROM login WHERE tipoLogin = 'DOCENTE'";
$resultDocentes = $conexion->query($sqlDocentes);

if ($resultDocentes === false) {
    die("Error en la consulta de docentes: " . $conexion->error);
}

// Consulta para obtener los FUTs desde la tabla 'fut'
$sqlFUTs = "SELECT nroFut, anioFut FROM fut"; 
$resultFUTs = $conexion->query($sqlFUTs);

if ($resultFUTs === false) {
    die("Error en la consulta de FUTs: " . $conexion->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asignar FUT</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        #fut-details {
            margin-top: 20px;
            border: 1px solid #ccc;
            padding: 15px;
            background-color: #f9f9f9;
        }
    </style>
    <script>
        function mostrarDetallesFUT() {
            const futSelect = document.getElementById('fut');
            const selectedValue = futSelect.value;
            const detailsDiv = document.getElementById('fut-details');

            if (selectedValue) {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'get_fut_details.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        detailsDiv.innerHTML = xhr.responseText;
                    }
                };
                xhr.send('fut=' + selectedValue);
            } else {
                detailsDiv.innerHTML = '';
            }
        }
    </script>
</head>
<body>

    <h1>Asignar FUT a Docente</h1>
    <form action="fut.php" method="post">
        <label for="docente">Seleccionar Docente:</label>
        <select name="docente" id="docente" required>
            <option value="" disabled selected>Seleccione un Docente</option>
            <?php
            while ($row = $resultDocentes->fetch_assoc()) {
                echo "<option value='{$row['codLogin']}'>{$row['usuLogin']}</option>";
            }
            ?>
        </select>

        <label for="fut">Seleccionar FUT:</label>
        <select name="fut" id="fut" required onchange="mostrarDetallesFUT()">
            <option value="" disabled selected>Seleccione un FUT</option>
            <?php
            while ($row = $resultFUTs->fetch_assoc()) {
                echo "<option value='{$row['nroFut']}'>{$row['nroFut']} - {$row['anioFut']}</option>";
            }
            ?>
        </select>

        <label for="descripcion">Descripción:</label>
        <input type="text" name="descripcion" id="descripcion" required>

        <button type="submit">Asignar FUT al Docente</button>
    </form>

    <div id="fut-details"></div>

</body>
</html>
