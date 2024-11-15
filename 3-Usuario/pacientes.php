<?php
session_start();

// Check if usuario_id is set in the session
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../1-Sesion/login.html"); // Redirect if not logged in
    exit();
}

// Include database connection
include '../0-php/conexion.php'; // Adjusted path to the database connection file

// Retrieve user information
$usuario_id = $_SESSION['usuario_id'];

// Retrieve associated pacientes
$stmt = $con->prepare("
    SELECT P.paciente_id, P.nombre 
    FROM Pacientes P
    JOIN Usuario_Paciente UP ON P.paciente_id = UP.paciente_id
    WHERE UP.usuario_id = ? AND UP.activo = TRUE
");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$pacientes_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Paciente</title>
    <link rel="stylesheet" href="../CSS/usuario.css"> <!-- Adjusted path to the CSS file -->
    <script src="../JS/quitarpacientes.js" defer></script> <!-- Include the JavaScript file -->
</head>
<body>

    <header>
        <h1>Eliminar Paciente</h1>
        <nav>
            <ul>
                <li><a href="PanelUsuario.php">Volver al Dashboard</a></li>
                <li><a href="../0-php/logout.php">Cerrar Sesión</a></li>
                <li><a href="new_page.php">Nueva Página</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Pacientes Asociados</h2>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($pacientes_result->num_rows > 0): ?>
                    <?php while ($paciente = $pacientes_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($paciente['nombre']); ?></td>
                            <td>
                                <button class="remove-button" data-paciente-id="<?php echo htmlspecialchars($paciente['paciente_id']); ?>">Eliminar</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">No hay pacientes asociados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>

</body>
</html>