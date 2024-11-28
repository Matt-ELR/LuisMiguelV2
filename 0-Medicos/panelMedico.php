<?php
session_start();

// Ensure the user is logged in and is a medic
if (!isset($_SESSION['tipo_cuenta']) || $_SESSION['tipo_cuenta'] !== 'Medico') {
    header("Location: ../1-Sesion/login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Médico</title>
    <link rel="stylesheet" href="../CSS/medicoPanel.css">
</head>
<body>
    <div class="container">
        <!-- Panel for linking patients -->
        <a href="linkPaciente.php" class="panel">
            <h2>Vincular Pacientes</h2>
            <p>Asocia pacientes a tu cuenta.</p>
        </a>

        <!-- Panel for viewing patient details -->
        <a href="paciente.php" class="panel">
            <h2>Detalles de Pacientes</h2>
            <p>Consulta la información de tus pacientes.</p>
        </a>
    </div>

    <!-- Logout Button -->
    <div class="logout-container">
        <button onclick="window.location.href='../0-php/logout.php'" class="logout-button">Cerrar Sesión</button>
    </div>
</body>
</html>
