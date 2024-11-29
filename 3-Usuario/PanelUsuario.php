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
$stmt = $con->prepare("SELECT nombre, edad FROM Usuarios WHERE usuario_id = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$user_result = $stmt->get_result();
$user = $user_result->fetch_assoc();

// Retrieve associated pacientes
$stmt = $con->prepare("
    SELECT P.paciente_id, P.nombre, P.edad, P.genero, P.altura, P.peso 
    FROM Pacientes P
    JOIN Usuario_Paciente UP ON P.paciente_id = UP.paciente_id
    WHERE UP.usuario_id = ? AND UP.activo = TRUE
");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$pacientes_result = $stmt->get_result();
$pacientes_count = $pacientes_result->num_rows; // Count of associated patients
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="../CSS/usuario.css"> <!-- Adjusted path to the CSS file -->
</head>
<body>

    <!-- Background -->
    <div class="background"></div>

    <!-- Main Container -->
    <div class="content-container">
        <header>
            <h1>Bienvenido, <?php echo htmlspecialchars($user['nombre']); ?></h1>
            <nav>
                <ul>
                    <li><a href="pacientes.php">Controlar pacientes</a></li>
                    <li><a href="informacion.php">Ver Información</a></li> <!-- Link to user info page -->
                    <li><a href="../0-php/logout.php">Cerrar Sesión</a></li>
                </ul>
            </nav>
        </header>

        <main>
            <h2>Pacientes Asociados</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Edad</th>
                        <th>Género</th>
                        <th>Altura</th>
                        <th>Peso</th>
                        <th>Menú</th> <!-- New column for the "Ver Menú" button -->
                    </tr>
                </thead>
                <tbody>
                    <?php if ($pacientes_count > 0): ?>
                        <?php while ($paciente = $pacientes_result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($paciente['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($paciente['edad']); ?></td>
                                <td><?php echo htmlspecialchars($paciente['genero']); ?></td>
                                <td><?php echo htmlspecialchars($paciente['altura']); ?> cm</td>
                                <td><?php echo htmlspecialchars($paciente['peso']); ?> kg</td>
                                <td>
                                    <!-- Button to view the menus of the patient -->
                                    <a href="../5-Menu/verMenus.php?paciente_id=<?php echo $paciente['paciente_id']; ?>" class="view-menu-button">Ver Menú</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">No hay pacientes asociados.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Button to add a new patient -->
            <?php if ($pacientes_count < 3): ?>
                <div>
                    <a href="../4-Paciente/FormularioPaciente.php" class="add-patient-button">Agregar Paciente</a>
                </div>
            <?php endif; ?>
        </main>
    </div>

</body>
</html>
