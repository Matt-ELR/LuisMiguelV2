<?php
session_start();

// Check if usuario_id is set in the session
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../1-Sesion/login.html"); // Redirect if not logged in
    exit();
}

// Include database connection
include '../0-php/conexion.php'; // Adjusted path to the database connection file

// Retrieve the paciente_id from the URL
$paciente_id = isset($_GET['paciente_id']) ? intval($_GET['paciente_id']) : 0;

// Retrieve all menus for the specified paciente_id, along with the medic's name
$stmt = $con->prepare("
    SELECT m.menu_id, m.texto, m.detalles_menu, m.fecha_creacion, med.nombre AS medic_name
    FROM menus m
    JOIN administrativo med ON m.medico_id = med.ID
    WHERE m.paciente_id = ? 
    ORDER BY m.fecha_creacion DESC
");
$stmt->bind_param("i", $paciente_id);
$stmt->execute();
$menus_result = $stmt->get_result();
$menus_count = $menus_result->num_rows; // Count of menus for the patient

// Fetch patient data (for display purposes)
$stmt_patient = $con->prepare("SELECT nombre, edad FROM pacientes WHERE paciente_id = ?");
$stmt_patient->bind_param("i", $paciente_id);
$stmt_patient->execute();
$patient_result = $stmt_patient->get_result();
$patient = $patient_result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menús del Paciente</title>
    <link rel="stylesheet" href="../CSS/vermenus.css"> <!-- Adjusted path to the CSS file -->
</head>
<body>

    <header>
        <h1>Menús de <?php echo htmlspecialchars($patient['nombre']); ?> (Edad: <?php echo htmlspecialchars($patient['edad']); ?>)</h1>
        <nav>
            <ul>
                <li><a href="../3-Usuario/pacientes.php">Volver a Pacientes</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Menús Disponibles</h2>
        <?php if ($menus_count > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Fecha de Creación</th>
                        <th>Detalles del Menú</th>
                        <th>Texto del Menú</th>
                        <th>Creado por</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($menu = $menus_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($menu['fecha_creacion']); ?></td>
                            <td><?php echo htmlspecialchars($menu['detalles_menu']); ?></td>
                            <td><?php echo htmlspecialchars($menu['texto']); ?></td>
                            <td><?php echo htmlspecialchars($menu['medic_name']); ?></td> <!-- Displaying the medic's name -->
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay menús disponibles para este paciente.</p>
        <?php endif; ?>
    </main>

</body>
</html>
