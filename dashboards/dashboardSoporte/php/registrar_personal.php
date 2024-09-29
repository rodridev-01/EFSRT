<?php
  include 'db_conexion.php';

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      $departamento = $_POST['departamento'];
      $provincia = $_POST['provincia'];
      $distrito = $_POST['distrito'];

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

      $tipoLogin = $tipoPersonal;
      $usuario = $correoJP;
      $contraseña = '';
      
      $sql_ultimo_codLogin = "SELECT MAX(codLogin) AS ultimoCodLogin FROM login";
      $result = $conexion->query($sql_ultimo_codLogin);
      $row = $result->fetch_assoc();

      if ($row['ultimoCodLogin'] !== NULL) {
          $nuevoCodLogin = $row['ultimoCodLogin'] + 1;
      } else {
          $nuevoCodLogin = 1;
      }

      $sql_login = "INSERT INTO login (codLogin, tipoLogin, usuLogin, passLogin, estadoLogin) 
                    VALUES (?, ?, ?, ?, 'H')";

      $stmt_login = $conexion->prepare($sql_login);
      $stmt_login->bind_param("isss", $nuevoCodLogin, $tipoLogin, $usuario, $contraseña);

      if ($stmt_login->execute()) {
          $codLogin = $nuevoCodLogin;

          $sql_personal = "INSERT INTO personal (codLogin, tipoPer, apPaterno, apMaterno, nombres, tipoDocu, nroDocu, 
                          telf, celular, correoJP, correoPersonal, direccion, codDis, codEsp, estable, anioNombramiento, 
                          anioCese, codigoPlaza, anioIngresoContratado, fechaIniContrato, fechaTerContrato, estado) 
                          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

          $stmt_personal = $conexion->prepare($sql_personal);
          $stmt_personal->bind_param("issssssssssssisiisisss", $codLogin, $tipoPersonal, $apellidoPaterno, $apellidoMaterno, 
                                    $nombresPersonal, $tipoDocumento, $nroDocumento, $telefono, $celular, $correoJP, 
                                    $correoPersonal, $direccion, $codDis, $codEsp, $estable, $anioNombramiento, 
                                    $anioCese, $codigoPlaza, $anioIngreso, $inicioContrato, $finContrato, $estadoPersonal);

          if ($stmt_personal->execute()) {
              echo "Registro del personal realizado con éxito. <a href='../index.php'>Ver Lista</a>";
          } else {
              echo "Error al insertar en la tabla personal: " . $stmt_personal->error;
          }
      } else {
          echo "Error al insertar en la tabla login: " . $stmt_login->error;
      }

      $conexion->close();
  } else {
      echo "Método no permitido.";
  }

?>