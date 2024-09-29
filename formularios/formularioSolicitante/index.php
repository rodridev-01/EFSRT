<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completa tu Solicitud</title>
    <link rel="stylesheet" href="estilos/estilos.css">
</head>

<body>

    <h1>Completa tu Solicitud</h1>

    <form class="form-solicitud" method="POST" action="formulario.php">

        <div class="input-row">
            <div class="form-group">
                <label for="apPaterno">Apellido Paterno</label>
                <input type="text" id="apPaterno" name="apPaterno" placeholder="A. Paterno" onkeypress="excepDatos(event,'letras',30)" required>
            </div>

            <div class="form-group">
                <label for="apMaterno">Apellido Materno</label>
                <input type="text" id="apMaterno" name="apMaterno" placeholder="A. Materno" onkeypress="excepDatos(event,'letras',30)" required>
            </div>

            <div class="form-group">
                <label for="nombres">Nombres</label>
                <input type="text" id="nombres" name="nombres" placeholder="Nombres" onkeypress="excepDatos(event,'letras',40)" required>
            </div>
        </div>

        <div class="input-row">
            <div class="form-group">
                <label for="tipoDocu">Tipo de documento</label>
                <select id="tipoDocu" name="tipoDocu" required>
                    <option value="" disabled selected>Selecciona un documento</option>
                    <option value="DNI">DNI</option>
                    <option value="CEX">CEX</option>
                    <option value="PAS">PAS</option>
                </select>
            </div>

            <div class="form-group">
                <label for="nroDocu">Nro Documento</label>
                <input type="text" id="nroDocu" name="nroDocu" placeholder="Nro Documento" onkeypress="excepDatos(event,'numeros',8)" required>
            </div>

            <div class="form-group">
                <label for="codModular">Código Modular</label>
                <input type="text" id="codModular" name="codModular" placeholder="Código Modular" onkeypress="maxDigitos(event,20)">
            </div>
        </div>

        <div class="input-row">
            <div class="form-group">
                <label for="telf">Teléfono</label>
                <input type="text" id="telf" name="telf" placeholder="Teléfono" onkeypress="excepDatos(event,'numeros',9)">
            </div>

            <div class="form-group">
                <label for="celular">Celular</label>
                <input type="text" id="celular" name="celular" placeholder="Celular" onkeypress="excepDatos(event,'numeros',9)">
            </div>
        </div>

        <div class="input-row">
            <div class="form-group">
                <label for="correoJP">Correo Institucional:</label>
                <input type="email" id="correoJP" name="correoJP" placeholder="example@jpardo.edu.pe" onkeypress="maxDigitos(event,80)" required>
            </div>

            <div class="form-group">
                <label for="correoPersonal">Correo Personal</label>
                <input type="email" id="correoPersonal" name="correoPersonal" placeholder="example@xxxxxx.com" onkeypress="maxDigitos(event,80)" required>
            </div>
        </div>

        <div class="form-group">
            <label for="direccion">Dirección:</label>
            <input type="text" id="direccion" name="direccion" placeholder="Domicilio" onkeypress="maxDigitos(event,120)">
        </div>

        <div class="input-row">

            <div class="form-group">
                <label for="departamento">Departamento</label>
                <select id="departamento" name="departamento" required>
                    <option value="" disabled selected>Selecciona departamento</option>
                </select>
            </div>

            <div class="form-group">
                <label for="provincia">Provincia</label>
                <select id="provincia" name="provincia" required>
                    <option value="" disabled selected>Selecciona provincia</option>
                </select>
            </div>

            <div class="form-group">
                <label for="distrito">Distrito</label>
                <select id="distrito" name="codDis" required>
                    <option value="" disabled selected>Selecciona un distrito</option>
                    <?php
                    // Asumiendo que obtienes los distritos de la tabla `ubigeo`
                    include 'php/cargar_distritos.php';
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="codigoEspecialidad">Especialidad</label>
                <select name="codigoEspecialidad" id="codigoEspecialidad" required>
                    <option value="">Seleccione Especialidad</option>
                    <?php include 'php/mostrar_especialidad.php'; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="anioIngreso">Año Ingreso</label>
                <input type="number" id="anioIngreso" name="anioIngreso" placeholder="YYYY" onkeypress="excepDatos(event,'numeros',4)" required>
            </div>

            <div class="form-group">
                <label for="anioEgreso">Año Egreso (Opcional)</label>
                <input type="number" id="anioEgreso" name="anioEgreso" placeholder="YYYY" onkeypress="excepDatos(event,'numeros',4)">
            </div>
        </div>

        <button type="submit">Enviar Solicitud</button>

    </form>
    <script src="js/ubigeo.js"></script>
    <script src="js/excepciones.js"></script>

</body>

</html>