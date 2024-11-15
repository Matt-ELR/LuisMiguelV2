<?php
session_start();

// Check if usuario_id is set in the session
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../1-Sesion/login.html"); // Redirect if not logged in
    exit();
}

// Include database connection
include '../0-php/conexion.php'; // Adjusted path to the database connection file

// Initialize error variable
$error = "";

// Include the processing script
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include '../0-php/añadirpaciente.php'; // Include the processing logic
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Agregar Paciente</title>
    <link rel="stylesheet" href="../CSS/usuario.css"> <!-- Adjusted path to the CSS file -->
</head>
<body>

    <header>
        <h1>Agregar Nuevo Paciente</h1>
        <nav>
            <ul>
                <li><a href="dashboard.php">Volver al Dashboard</a></li>
                <li><a href="../0-php/logout.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <?php if ($error): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="nombre">Nombre:</label><br>
            <input type="text" id="nombre" name="nombre" required><br><br>

            <label for="edad">Edad:</label><br>
            <input type="number" id="edad" name="edad" required><br><br>

            <label for="genero">Género:</label><br>
            <select id="genero" name="genero" required>
                <option value="Masculino">Masculino</option>
                <option value="Femenino">Femenino</option>
                <option value="Otro">Otro</option>
            </select><br><br>

            <label for="altura">Altura (cm):</label><br>
            <input type="number" id="altura" name="altura" required><br><br>

            <label for="peso">Peso (kg):</label><br>
            <input type="number" id="peso" name="peso" required><br><br>

            <label for="nivel_erc">Nivel de ERC:</label><br>
            <input type="text" id="nivel_erc" name="nivel_erc" required><br><br>

            <label for="comida_favorita">Comida Favorita:</label><br>
            <input type="text" id="comida_favorita" name="comida_favorita" required><br><br>

            <label for="disgustos">Disgustos:</label><br>
            <input type="text" id="disgustos" name="disgustos" required><br><br>

            <button type="submit">Agregar Paciente</button>
        </form>
    </main>
</body>
</html>