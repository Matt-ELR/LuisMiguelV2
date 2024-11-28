<?php
session_start();

// Ensure the user is logged in and is a medic
if (!isset($_SESSION['tipo_cuenta']) || $_SESSION['tipo_cuenta'] !== 'Medico') {
    header("Location: ../1-Sesion/login.html");
    exit();
}

include '../0-php/conexion.php'; // Database connection

// Get the medic's ID from the session
$medico_id = $_SESSION['ID'];

// Query to fetch all linked patients for the medic
$stmt = $con->prepare("SELECT p.paciente_id, p.nombre, p.edad, p.genero FROM pacientes p 
                        JOIN `Medico-Paciente` mp ON p.paciente_id = mp.paciente_id 
                        WHERE mp.medico_id = ?");
$stmt->bind_param("i", $medico_id);
$stmt->execute();
$result = $stmt->get_result();

$linked_patients = [];
while ($row = $result->fetch_assoc()) {
    $linked_patients[] = $row;
}

$stmt->close();
$con->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pacientes Vinculados</title>
    <link rel="stylesheet" href="../CSS/verpacientes.css">
</head>
<body>
<div class="back-button-container">
    <button onclick="window.location.href='panelMedico.php'" class="back-button">Volver al Panel</button>
</div>

    <div class="container">
        <h1>Pacientes Vinculados</h1>
        
        <!-- Table to display linked patients -->
        <table class="patient-table">
            <thead>
                <tr>
                    <th>ID Paciente</th>
                    <th>Nombre</th>
                    <th>Edad</th>
                    <th>Género</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($linked_patients) > 0): ?>
                    <?php foreach ($linked_patients as $patient): ?>
                        <tr>
                            <td><?= htmlspecialchars($patient['paciente_id']); ?></td>
                            <td><?= htmlspecialchars($patient['nombre']); ?></td>
                            <td><?= htmlspecialchars($patient['edad']); ?></td>
                            <td><?= htmlspecialchars($patient['genero']); ?></td>
                            <td>
                                <!-- Button to redirect to crearmenu.php for the current patient -->
                                <a href="crearmenu.php?paciente_id=<?= htmlspecialchars($patient['paciente_id']); ?>" class="button">Crear Menú</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No hay pacientes vinculados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        
    </div>
</body>
</html>
