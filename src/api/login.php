<?php
session_start(); // Iniciar sesión

$servername = "localhost";
$username = "liveraco_pruebabd";
$password = "JosePardo*2411";
$dbname = "liveraco_efsrtBD";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si los campos requeridos están presentes
if (!isset($_POST['role']) || !isset($_POST['email']) || !isset($_POST['password'])) {
    die("Error: Faltan datos necesarios para el inicio de sesión.");
}

$role = htmlspecialchars($_POST['role']);
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$password = $_POST['password'];

// Validar el correo electrónico
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Error: El correo electrónico no es válido.");
}

// Llamar al procedimiento almacenado para obtener la contraseña y el rol
$sql = "CALL sp_getUserPasswordAndRole(?, @passLogin, @tipoLogin)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Error: " . $conn->error);
}

$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->close();

// Obtener los resultados de la contraseña y rol
$result = $conn->query("SELECT @passLogin AS passLogin, @tipoLogin AS tipoLogin");
$row = $result->fetch_assoc();

// Verificar si se encontró el usuario
if (!$row || !isset($row['passLogin'])) {
    die("Error: Usuario no encontrado.");
}

$hashed_password = $row['passLogin'];
$stored_role = $row['tipoLogin'];

// Verificar la contraseña
if (password_verify($password, $hashed_password)) {

    // Verificar si el rol coincide
    if ($role === $stored_role) {

        // Obtener el codLogin basado en el correo electrónico (usuLogin)
        $sql_codLogin = "SELECT codLogin FROM login WHERE usuLogin = ?";
        $stmt_codLogin = $conn->prepare($sql_codLogin);
        $stmt_codLogin->bind_param("s", $email);
        $stmt_codLogin->execute();
        $result_codLogin = $stmt_codLogin->get_result();
        $row_codLogin = $result_codLogin->fetch_assoc();
        if ($row_codLogin) {
            // Guardar el codLogin en la sesión
            $_SESSION['codLogin'] = $row_codLogin['codLogin'];
        } else {
            die("Error: No se encontró el codLogin para este usuario.");
        }

        // Redirigir a la página según el rol
        if ($role === "SOPORTE") {
            header("Location: ../../dashboards/dashboardSoporte/index.php");
            exit();
        } else if ($role === "COORDINADOR") {
            header("Location: ../../dashboards/dashboardCoordinador/home.php");
            exit();
        } else if ($role === "DIRECTIVO") {
            header("Location: ../../dashboards/dashboarDirectivo/home.php");
            exit();
        } else if ($role === "DOCENTE") {
            header("Location: ../../dashboards/dashboardDocente/home.php");
            exit();
        } else {
            header("Location: ../../dashboards/dashboardSolicitante/home.php");
        }
    } else {
        die("Error: Rol incorrecto.");
    }
} else {
    die("Error: Contraseña incorrecta.");
}

// Cerrar la conexión
$conn->close();

