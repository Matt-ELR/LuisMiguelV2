<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../1-Sesion/login.html");
    exit();
}

include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario_id = $_SESSION['usuario_id'];
    $correo = $_POST['correo'];
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $edad = $_POST['edad'];

    // Update user information
    $sql = "UPDATE Usuarios SET correo = ?, nombre = ?, telefono = ?, edad = ? WHERE usuario_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("sssii", $correo, $nombre, $telefono, $edad, $usuario_id);

    if ($stmt->execute()) {
        echo "<script>alert('Información actualizada exitosamente.'); window.location.href='../3-Usuario/informacion.php';</script>";
    } else {
        echo "<script>alert('Error al actualizar la información.'); window.location.href='../3-Usuario/informacion.php';</script>";
    }

    $stmt->close();
}

$con->close();
?>
