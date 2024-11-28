<?php
session_start();

// Ensure the user is logged in and is a medic
if (!isset($_SESSION['tipo_cuenta']) || $_SESSION['tipo_cuenta'] !== 'Medico') {
    header("Location: ../1-Sesion/login.html");
    exit();
}

include '../0-php/conexion.php'; // Database connection

// Variable to store feedback messages
$message = "";
$paciente_data = null;

// Search for patient when ID is entered
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['paciente_id'])) {
    $paciente_id = intval($_POST['paciente_id']);

    // Query to find the patient in the database
    $stmt = $con->prepare("SELECT * FROM pacientes WHERE paciente_id = ?");
    $stmt->bind_param("i", $paciente_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $paciente_data = $result->fetch_assoc();

    if (!$paciente_data) {
        $message = "Paciente no encontrado. Verifica el ID ingresado.";
    }

    $stmt->close();
}

// Fetch linked patients
$medico_id = $_SESSION['ID'];
$linked_patients = [];
$stmt = $con->prepare("SELECT p.paciente_id, p.nombre, p.edad, p.genero 
                       FROM `Medico-Paciente` mp 
                       JOIN pacientes p ON mp.paciente_id = p.paciente_id 
                       WHERE mp.medico_id = ?");
$stmt->bind_param("i", $medico_id);
$stmt->execute();
$result = $stmt->get_result();
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
    <title>Vincular Pacientes</title>
    <link rel="stylesheet" href="../CSS/linkPaciente.css">
</head>
<body>
<div class="back-button-container">
    <button onclick="window.location.href='panelMedico.php'" class="back-button">Volver al Panel</button>
</div>

    <div class="container">
        <h1>Vincular Paciente</h1>

        <!-- Form to search for a patient -->
        <form method="POST" action="">
            <label for="paciente_id">Ingrese el ID del Paciente:</label>
            <input type="number" name="paciente_id" id="paciente_id" required>
            <button type="submit">Verificar</button>
        </form>

        <!-- Display feedback messages -->
        <?php if ($message): ?>
            <p class="message"><?= htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <!-- Display patient data if found -->
        <?php if ($paciente_data): ?>
            <div class="patient-details">
                <h2>Detalles del Paciente</h2>
                <p><strong>ID:</strong> <?= htmlspecialchars($paciente_data['paciente_id']); ?></p>
                <p><strong>Nombre:</strong> <?= htmlspecialchars($paciente_data['nombre']); ?></p>
                <p><strong>Edad:</strong> <?= htmlspecialchars($paciente_data['edad']); ?></p>
                <p><strong>Género:</strong> <?= htmlspecialchars($paciente_data['genero']); ?></p>

                <!-- Confirm or Cancel Options -->
                <form method="POST" action="../0-php/linkPacienteAction.php">
                    <input type="hidden" name="paciente_id" value="<?= htmlspecialchars($paciente_data['paciente_id']); ?>">
                    <button type="submit">Confirmar Vinculación</button>
                </form>
                <button onclick="window.location.href='linkPaciente.php'">Cancelar</button>
            </div>
        <?php endif; ?>

        <!-- Display linked patients -->
        <div class="linked-patients">
            <h2>Pacientes Vinculados</h2>
            <?php if (count($linked_patients) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Edad</th>
                            <th>Género</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($linked_patients as $patient): ?>
                            <tr>
                                <td><?= htmlspecialchars($patient['paciente_id']); ?></td>
                                <td><?= htmlspecialchars($patient['nombre']); ?></td>
                                <td><?= htmlspecialchars($patient['edad']); ?></td>
                                <td><?= htmlspecialchars($patient['genero']); ?></td>
                                <td>
                                    <form method="POST" action="../0-php/unlinkPacienteAction.php">
                                        <input type="hidden" name="paciente_id" value="<?= htmlspecialchars($patient['paciente_id']); ?>">
                                        <button type="submit">Desvincular</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No hay pacientes vinculados actualmente.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
