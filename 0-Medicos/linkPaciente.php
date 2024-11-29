<?php
session_start();
if (!isset($_SESSION['ID'])) {
    header("Location: ../1-Sesion/login.html");
    exit();
}

// Include database connection
require_once "../0-php/conexion.php";

// Get the current medic's ID
$medico_id = $_SESSION['ID'];

// Fetch unlinked patients
$sqlUnlinked = "SELECT paciente_id, nombre, edad 
                FROM pacientes 
                WHERE paciente_id NOT IN (
                    SELECT paciente_id 
                    FROM `medico-paciente`
                )";
$resultUnlinked = $con->query($sqlUnlinked);

// Fetch patients linked to the current medic
$sqlLinked = "SELECT p.paciente_id, p.nombre, p.edad, mp.numero_control 
              FROM pacientes p
              INNER JOIN `medico-paciente` mp ON p.paciente_id = mp.paciente_id
              WHERE mp.medico_id = ?";
$stmtLinked = $con->prepare($sqlLinked);
$stmtLinked->bind_param("i", $medico_id);
$stmtLinked->execute();
$resultLinked = $stmtLinked->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vincular Pacientes</title>
    <link rel="stylesheet" href="../CSS/linkpaciente.css">
</head>
<body>
    <header>
        <h1>Vincular Pacientes</h1>
    </header>

    <!-- Button to return to panelMedico.php -->
    <div class="back-button">
        <a href="panelMedico.php" class="action-btn">Volver al Panel Médico</a>
    </div>

    <h2>Pacientes Sin Vincular</h2>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Edad</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $resultUnlinked->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nombre']) ?></td>
                        <td><?= htmlspecialchars($row['edad']) ?></td>
                        <td>
                            <form method="POST" action="../0-php/linkPacienteAction.php">
                                <input type="hidden" name="paciente_id" value="<?= $row['paciente_id'] ?>">
                                <button type="submit" name="link" class="action-btn">Vincular</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <h2>Pacientes Vinculados</h2>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Edad</th>
                    <th>Número de Control</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $resultLinked->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nombre']) ?></td>
                        <td><?= htmlspecialchars($row['edad']) ?></td>
                        <td><?= htmlspecialchars($row['numero_control']) ?></td>
                        <td>
                            <form method="POST" action="../0-php/unlinkPacienteAction.php">
                                <input type="hidden" name="paciente_id" value="<?= $row['paciente_id'] ?>">
                                <button type="submit" name="unlink" class="action-btn unlink">Desvincular</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
