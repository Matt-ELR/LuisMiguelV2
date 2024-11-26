<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['tipo_cuenta']) || $_SESSION['tipo_cuenta'] !== 'Admin') {
    header("Location: ../1-Sesion/login.html");
    exit();
}

// Check if a user ID is provided
if (!isset($_GET['user_id'])) {
    die("No user ID provided.");
}

$user_id = $_GET['user_id'];

// Prepare the delete statement for the user
$sql = "DELETE FROM Usuarios WHERE usuario_id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    echo "<script>
        alert('Cuenta eliminada exitosamente.');
        location.href='gestionarCuentas.php';
    </script>";
} else {
    echo "<script>
        alert('Error al eliminar la cuenta.');
        location.href='gestionarCuentas.php';
    </script>";
}

$stmt->close();
$con->close();
?>
