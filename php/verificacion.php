<?php
session_start();
include 'conexion.php'; // Conecta a la BD

// Consigue datos
$username = $_POST['username'];
$password = $_POST['password'];

// Retrieve user information from database
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && password_verify($password, $user['password'])) {
    // Successful login
    $_SESSION['username'] = $user['username'];
    $_SESSION['account_type'] = $user['account_type'];

    // Redirect based on account type
    if ($user['account_type'] === 'admin') {
        header("Location: ../Admin/panel-admin.php");
    } elseif ($user['account_type'] === 'medico') {
        header("Location: ../Medico/panel-medico.php");
    } else {
        header("Location: ../Paciente/panel-paciente.php");
    }
    exit();
} else {
    // Login failed
    echo "<script>
    alert('Invalid username or password!');
    location.href='../Sesion/login.html';
    </script>";
}

// Close the database connection
$stmt->close();
$con->close();
?>
