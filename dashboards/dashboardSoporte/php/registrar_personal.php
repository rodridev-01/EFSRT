<?php
include 'db_conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $departamento = $_POST['departamento'];
    $provincia = $_POST['provincia'];
    $distrito = $_POST['distrito'];

    // Obtener el código de ubigeo
    $queryUbigeo = "CALL obtener_codigo_ubigeo(?, ?, ?)";
    $stmtUbigeo = $conexion->prepare($queryUbigeo);
    $stmtUbigeo->bind_param("sss", $departamento, $provincia, $distrito);
    $stmtUbigeo->execute();
    $resultUbigeo = $stmtUbigeo->get_result();

    if ($resultUbigeo->num_rows > 0) {
        $rowUbigeo = $resultUbigeo->fetch_assoc();
        $codDis = $rowUbigeo['codUbi'];
    } else {
        echo "No se encontró el código de ubigeo para el distrito seleccionado.";
        exit();
    }
    $stmtUbigeo->close();

    // Datos adicionales del formulario
    $tipoPersonal = $_POST['tipoPersonal'];
    $apellidoPaterno = $_POST['apellidoPaterno'];
    $apellidoMaterno = $_POST['apellidoMaterno'];
    $nombresPersonal = $_POST['nombresPersonal'];
    $tipoDocumento = $_POST['tipoDocumento'];
    $nroDocumento = $_POST['nroDocumento'];
    $telefono = $_POST['telefono'];
    $celular = $_POST['celular'];
    $correoJP = $_POST['correoJosePardo'];
    $correoPersonal = $_POST['correoPersonal'];
    $direccion = $_POST['direccion'];
    $codEsp = isset($_POST['codigoEspecialidad']) ? $_POST['codigoEspecialidad'] : NULL;
    $estable = isset($_POST['estable']) ? $_POST['estable'] : NULL;
    $anioNombramiento = isset($_POST['anioNombramiento']) ? $_POST['anioNombramiento'] : NULL;
    $anioCese = isset($_POST['anioCese']) ? $_POST['anioCese'] : NULL;
    $codigoPlaza = $_POST['codigoPlaza'];
    $anioIngreso = isset($_POST['anioContrato']) ? $_POST['anioContrato'] : NULL;
    $inicioContrato = isset($_POST['inicioContrato']) ? $_POST['inicioContrato'] : NULL;
    $finContrato = isset($_POST['finContrato']) ? $_POST['finContrato'] : NULL;
    $estadoPersonal = $_POST['estadoPersonal'];

    // Datos para la tabla login
    $tipoLogin = $tipoPersonal;
    $usuario = $correoJP;
    $contraseñaOriginal = 'Soporte2024$';
    $contraseñaHasheada = password_hash($contraseñaOriginal, PASSWORD_BCRYPT);

    // Llamar al procedimiento almacenado 'registrar_personal'
    $queryRegistrarPersonal = "CALL registrar_personal(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmtRegistrarPersonal = $conexion->prepare($queryRegistrarPersonal);
    
    $stmtRegistrarPersonal->bind_param(
        "sssssssssssssssisiisisss",
        $tipoLogin, $usuario, $contraseñaHasheada, $tipoPersonal, $apellidoPaterno, $apellidoMaterno, 
        $nombresPersonal, $tipoDocumento, $nroDocumento, $telefono, $celular, $correoJP, 
        $correoPersonal, $direccion, $codDis, $codEsp, $estable, $anioNombramiento, 
        $anioCese, $codigoPlaza, $anioIngreso, $inicioContrato, $finContrato, $estadoPersonal
    );

    if ($stmtRegistrarPersonal->execute()) {
        $result = $stmtRegistrarPersonal->get_result();
        $row = $result->fetch_assoc();
        $codLogin = $row['codigoLogin']; // Código de login generado
        // echo "Registro del personal realizado con éxito. Código de login: $codLogin. <a href='../index.php'>Ver Lista</a>";
        header("location:../index.php");
    } else {
        echo "Error al registrar el personal: " . $stmtRegistrarPersonal->error;
    }

    // Cerrar la conexión
    $stmtRegistrarPersonal->close();
    $conexion->close();
} else {
    echo "Método no permitido.";
}
?>