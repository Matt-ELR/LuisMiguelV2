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
    <script src="../JS/panelAdmin.js"></script>

</head>
<body>
    <div class="container">
        <!-- Panel for handling payment vouchers -->
        <a href="../0-Admin/validarPago.php" class="panel">
            <h2>Validar Comprobantes</h2>
        </a>

        <!-- Panel for creating new administrative accounts -->
        <a href="../0-Admin/crearCuentas.php" class="panel">
            <h2>Crear Cuentas</h2>
        </a>

        <!-- Panel for handling accounts and patients -->
        <a href="../0-Admin/gestionarCuentas.php" class="panel">
            <h2>Gestionar Cuentas y Pacientes</h2>
        </a>
    </div>

    <!-- Logout Button -->
    <div class="logout-container">
        <button onclick="window.location.href='../0-php/logout.php'" class="logout-button">Cerrar Sesión</button>
    </div>
</body>
</html>
