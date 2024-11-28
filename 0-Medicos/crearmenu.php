<?php
session_start();

// Ensure the user is logged in and is a medic
if (!isset($_SESSION['tipo_cuenta']) || $_SESSION['tipo_cuenta'] !== 'Medico') {
    header("Location: ../1-Sesion/login.html");
    exit();
}

include '../0-php/conexion.php'; // Database connection

// Fetch the paciente_id from URL
$paciente_id = isset($_GET['paciente_id']) ? intval($_GET['paciente_id']) : 0;

// Fetch the patient details
$stmt = $con->prepare("SELECT paciente_id, nombre, edad, genero, altura, peso, nivel_erc, comida_favorita, disgustos 
                      FROM pacientes WHERE paciente_id = ?");
$stmt->bind_param("i", $paciente_id);
$stmt->execute();
$result = $stmt->get_result();
$patient_data = $result->fetch_assoc();

if (!$patient_data) {
    echo "<script>alert('Paciente no encontrado.'); window.location.href='panelMedico.php';</script>";
    exit();
}

$stmt->close();

// Handle menu creation form submission
$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['menu_text'])) {
    $menu_text = $_POST['menu_text'];
    $medico_id = $_SESSION['ID'];
    $detalles_menu = isset($_POST['detalles_menu']) ? $_POST['detalles_menu'] : "";

    // Insert the new menu into the database
    $stmt = $con->prepare("INSERT INTO menus (paciente_id, medico_id, detalles_menu, texto) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $paciente_id, $medico_id, $detalles_menu, $menu_text);

    if ($stmt->execute()) {
        $message = "Menú creado exitosamente.";
    } else {
        $message = "Error al crear el menú. Intenta nuevamente.";
    }

    $stmt->close();
}

// Fetch existing menus for the patient (all menus associated with the paciente_id)
$stmt = $con->prepare("SELECT menu_id, detalles_menu, texto, fecha_creacion, medico_id 
                       FROM menus WHERE paciente_id = ?");
$stmt->bind_param("i", $paciente_id);
$stmt->execute();
$menus_result = $stmt->get_result();
$menus = [];
while ($row = $menus_result->fetch_assoc()) {
    $menus[] = $row;
}

$stmt->close();
$con->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Menú</title>
    <link rel="stylesheet" href="../CSS/crearmenu.css">
</head>
<body>
    <div class="container">
        <h1>Crear Menú para el Paciente</h1>

        <!-- Display patient information -->
        <div class="patient-info">
            <h2>Detalles del Paciente</h2>
            <p><strong>ID:</strong> <?= htmlspecialchars($patient_data['paciente_id']); ?></p>
            <p><strong>Nombre:</strong> <?= htmlspecialchars($patient_data['nombre']); ?></p>
            <p><strong>Edad:</strong> <?= htmlspecialchars($patient_data['edad']); ?></p>
            <p><strong>Género:</strong> <?= htmlspecialchars($patient_data['genero']); ?></p>
            <p><strong>Altura:</strong> <?= htmlspecialchars($patient_data['altura']); ?> cm</p>
            <p><strong>Peso:</strong> <?= htmlspecialchars($patient_data['peso']); ?> kg</p>
            <p><strong>Nivel ERC:</strong> <?= htmlspecialchars($patient_data['nivel_erc']); ?></p>
            <p><strong>Comida Favorita:</strong> <?= htmlspecialchars($patient_data['comida_favorita']); ?></p>
            <p><strong>Disgustos:</strong> <?= htmlspecialchars($patient_data['disgustos']); ?></p>
        </div>

        <!-- Display feedback messages -->
        <?php if ($message): ?>
            <p class="message"><?= htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <!-- Menu creation form -->
        <form method="POST" action="">
            <div class="form-group">
                <label for="detalles_menu">Detalles del Menú (opcional):</label>
                <textarea name="detalles_menu" id="detalles_menu" rows="4" placeholder="Inserta los datos del menú (Nombre, tiempo aproximado de preparación, etc...)"></textarea>
            </div>
            
            <div class="form-group">
                <label for="menu_text">Texto del Menú:</label>
                <textarea name="menu_text" id="menu_text" rows="6" required placeholder="Ingresa el plan de alimentación aquí..."></textarea>
            </div>
            
            <button type="submit">Crear Menú</button>
        </form>

        <!-- Table to display existing menus for the patient -->
        <h2>Menús Existentes</h2>
        <?php if (count($menus) > 0): ?>
            <table class="menu-table">
                <thead>
                    <tr>
                        <th>ID Menú</th>
                        <th>Detalles del Menú</th>
                        <th>Texto del Menú</th>
                        <th>Fecha de Creación</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($menus as $menu): ?>
                        <tr>
                            <td><?= htmlspecialchars($menu['menu_id']); ?></td>
                            <td><?= htmlspecialchars($menu['detalles_menu']); ?></td>
                            <td><?= htmlspecialchars($menu['texto']); ?></td>
                            <td><?= htmlspecialchars($menu['fecha_creacion']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay menús creados para este paciente.</p>
        <?php endif; ?>

        <!-- Back button to go back to the linked patients page -->
        <div class="back-button">
            <button onclick="window.location.href='paciente.php'">Volver a Pacientes Vinculados</button>
        </div>
    </div>
</body>
</html>
