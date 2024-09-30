<?php
include 'db_conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Combobox Departamento, provincia y distrito
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

    // if ($codDis) {
    //     echo "Código de distrito encontrado: $codDis";
    // } else {
    //     echo "Error: Código de distrito no encontrado.";
    // }

    // Recibir todos los valores del formulario
    $codLogin = $_POST['codLogin'];
    $apPaterno = $_POST['apellidoPaterno'];
    $apMaterno = $_POST['apellidoMaterno'];
    $nombresPersonal = $_POST['nombresPersonal'];
    $tipoDocumento = $_POST['tipoDocumento'];
    $nroDocumento = $_POST['nroDocumento'];
    $telefono = $_POST['telefono'];
    $celular = $_POST['celular'];
    $correoJP = $_POST['correoJosePardo'];
    $correoPersonal = $_POST['correoPersonal'];
    $codEsp = isset($_POST['codigoEspecialidad']) ? $_POST['codigoEspecialidad'] : NULL;
    $direccion = $_POST['direccion'];
    $estable = isset($_POST['estable']) ? $_POST['estable'] : NULL;
    $anioNombramiento = isset($_POST['anioNombramiento']) ? $_POST['anioNombramiento'] : NULL;
    $anioCese = isset($_POST['anioCese']) ? $_POST['anioCese'] : NULL;
    $codigoPlaza = $_POST['codigoPlaza'];
    $anioIngresoContratado = isset($_POST['anioContrato']) ? $_POST['anioContrato'] : NULL;
    $fechaIniContrato = isset($_POST['inicioContrato']) ? $_POST['inicioContrato'] : NULL;
    $fechaTerContrato = isset($_POST['finContrato']) ? $_POST['finContrato'] : NULL;
    $estadoPersonal = $_POST['estadoPersonal'];
    $tipoPersonal = $_POST['tipoPersonal'];

    // Preparar la llamada al procedimiento almacenado
    $sql = "CALL actualizar_personal(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("issssssssssissiisissss", $codLogin, $apPaterno, $apMaterno, $nombresPersonal, 
                        $tipoDocumento, $nroDocumento, $telefono, $celular, $correoJP, 
                        $correoPersonal, $codDis, $codEsp, $direccion, $estable, $anioNombramiento, 
                        $anioCese, $codigoPlaza, $anioIngresoContratado, $fechaIniContrato, 
                        $fechaTerContrato, $estadoPersonal, $tipoPersonal);

    // Ejecutar la actualización
    if ($stmt->execute()) {
        // echo "El registro ha sido actualizado con éxito.";
        // Redireccionar al CRUD después de actualizar
        header("Location: ../index.php");
    } else {
        echo "Error al actualizar el registro: " . $conexion->error;
    }
    $stmt->close();
    $conexion->close();
}
?>