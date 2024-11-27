<?php
session_start();

// Ensure the user is logged in and is a medic
if (!isset($_SESSION['tipo_cuenta']) || $_SESSION['tipo_cuenta'] !== 'Medico') {
    header("Location: ../1-Sesion/login.html");
    exit();
}

include '../0-php/conexion.php'; // Database connection

// Debugging: Print session ID to verify it's set correctly
echo "Session ID: " . $_SESSION['ID']; // Debugging line
echo "<br>";

// Fetch medic details
$medico_id = $_SESSION['ID']; // Use the session variable 'ID' here
// Make sure to use the correct column name in the table (ID or medico_id)
$stmt = $con->prepare("SELECT nombre FROM Administrativo WHERE ID = ?");
$stmt->bind_param("i", $medico_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the query returns any result
if ($result->num_rows === 0) {
    echo "<script>alert('Médico no encontrado.'); window.location.href='../1-Sesion/login.html';</script>";
    exit();
}

// Fetch the medic details
$medico = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard del Médico</title>
    <link rel="stylesheet" href="../CSS/medicDashboard.css">
</head>
<body>
    <header>
        <h1>Bienvenido, Dr. <?= htmlspecialchars($medico['nombre']); ?></h1>
        <nav>
            <ul>
                <li><a href="../0-php/logout.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="panel-container">
            <div class="panel" onclick="window.location.href='linkPaciente.php'">
                <h2>Vincular Pacientes</h2>
                <p>Asocia pacientes a tu cuenta.</p>
            </div>
            <div class="panel" onclick="window.location.href='viewPaciente.php'">
                <h2>Detalles de Pacientes</h2>
                <p>Consulta la información de tus pacientes.</p>
            </div>
            <div class="panel" onclick="window.location.href='buildMenu.php'">
                <h2>Construir Menú</h2>
                <p>Crea un plan de alimentación personalizado.</p>
            </div>
        </div>
    </main>
</body>
</html>
