<?php
session_start();
$servername = "localhost";
$username = "liveraco_pruebabd";
$password = "JosePardo*2411";
$dbname = "liveraco_efsrtBD";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$password = $_POST['password'];
$role = "SOLICITANTE";  // Forzar rol Solicitante


$valid_domains = ['jpardo.edu.pe', 'josepardo.edu.pe'];
$email_domain = substr(strrchr($email, "@"), 1);

if (!in_array($email_domain, $valid_domains)) {
    die("Error: El correo debe pertenecer a los dominios jpardo.edu.pe o josepardo.edu.pe.");
}


if (strlen($password) < 8 || !preg_match("/[a-z]/", $password) || !preg_match("/[A-Z]/", $password) || !preg_match("/\W/", $password)) {
    die("Error: La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula y un símbolo especial.");
}

$hashed_password = password_hash($password, PASSWORD_DEFAULT);


$sql = "SELECT * FROM login WHERE usuLogin = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    die("Error: El correo electrónico ya está registrado.");
}


$sql = "INSERT INTO login (tipoLogin, usuLogin, passLogin) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $role, $email, $hashed_password);
  
    $sqlLastLogin = "SELECT codLogin FROM login ORDER BY codLogin DESC LIMIT 1";
    $resultLastLogin = $conn->query($sqlLastLogin);
    $rowLastLogin = $resultLastLogin->fetch_assoc();
    $codLogin = $rowLastLogin['codLogin'];
     $_SESSION['codLogin'] = $codLogin;
    
if ($stmt->execute()) {
  
    header("Location: ../formularioSolicitante/");
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
