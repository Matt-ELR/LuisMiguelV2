<?php
session_start();

// Ensure the user is logged in and is an admin
if (!isset($_SESSION['tipo_cuenta']) || $_SESSION['tipo_cuenta'] !== 'Admin') {
    header("Location: ../1-Sesion/login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrativo</title>
    <link rel="stylesheet" href="../CSS/adminPanel.css">
</head>
<body>
    <div class="container">
        <!-- Panel for handling payment vouchers -->
        <div class="panel">
            <h2>Validar Comprobantes</h2>
            <a href="../0-Admin/validarComprobantes.php">Ir a validación</a>
        </div>

        <!-- Panel for creating new administrative accounts -->
        <div class="panel">
            <h2>Crear Cuentas</h2>
            <a href="../0-Admin/crearCuentas.php">Ir a creación</a>
        </div>

        <!-- Panel for handling accounts and patients -->
        <div class="panel">
            <h2>Gestionar Cuentas y Pacientes</h2>
            <a href="../0-Admin/gestionarCuentas.php">Ir a gestión</a>
        </div>
    </div>
</body>
</html>
