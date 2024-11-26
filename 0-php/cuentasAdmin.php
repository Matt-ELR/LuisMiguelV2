<?php
session_start();
include 'conexion.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../1-Sesion/login.html");
    exit();
}

// Check if the user is an admin
if (!isset($_SESSION['tipo_cuenta']) || $_SESSION['tipo_cuenta'] !== 'Admin') {
    die("Acceso denegado.");
}

// Retrieve form data
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];
$nombre = $_POST['nombre'];
$contraseña = $_POST['contraseña'];
$tipo_cuenta = $_POST['tipo_cuenta'];

// Hash the password
$hashedPassword = password_hash($contraseña, PASSWORD_BCRYPT);

// Prepare and execute the SQL statement
$sql = "INSERT INTO Administrativo (correo, telefono, nombre, contraseña, tipo_cuenta) VALUES (?, ?, ?, ?, ?)";
$stmt = $con->prepare($sql);
$stmt->bind_param("sssss", $correo, $telefono, $nombre, $hashedPassword, $tipo_cuenta);

if ($stmt->execute()) {
    echo "<script>
        alert('Cuenta creada exitosamente.');
        location.href='../0-Admin/panelAdmin.php';
    </script>";
} else {
    echo "<script>
        alert('Error al crear la cuenta. Por favor, intente de nuevo.');
        location.href='../0-Admin/crearCuentas.php';
    </script>";
}

// Close resources
$stmt->close();
$con->close();
?>
