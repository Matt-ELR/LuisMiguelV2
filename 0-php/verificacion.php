<?php
session_start();
include 'conexion.php'; // Include database connection

// Get user input
$correo = $_POST['correo'];
$contraseña = $_POST['contraseña'];

// Retrieve user information from database
$sql = "SELECT * FROM Usuarios WHERE correo = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && password_verify($contraseña, $user['contraseña'])) { // Verify the hashed password
    // Successful login
    $_SESSION['correo'] = $user['correo'];
    $_SESSION['nombre'] = $user['nombre'];
    $_SESSION['usuario_id'] = $user['usuario_id'];
    $_SESSION['account_type'] = $user['account_type']; // Assuming you have this field
    $_SESSION['username'] = $user['nombre']; // Assuming you want to display the name
    
    // Redirect to a default user panel or dashboard
    header("Location: ../3-Usuario/PanelUsuario.php");
    exit();
} else {
    // Login failed
    echo "<script>
    alert('Correo o contraseña inválidos!');
    location.href='../1-Sesion/login.html';
    </script>";
}

// Close the database connection
$stmt->close();
$con->close();
?>