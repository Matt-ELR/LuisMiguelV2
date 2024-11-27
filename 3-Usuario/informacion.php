<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../1-Sesion/login.html");
    exit();
}

include '../0-php/conexion.php'; // Database connection

// Fetch user information
$usuario_id = $_SESSION['usuario_id'];
$sql = "SELECT * FROM Usuarios WHERE usuario_id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo "<script>alert('Usuario no encontrado.'); window.location.href='panelUsuario.php';</script>";
    exit();
}

$stmt->close();
$con->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <link rel="stylesheet" href="../CSS/informacion.css">
    <script>
        function toggleEdit() {
            const fields = document.querySelectorAll('.editable');
            const saveButton = document.getElementById('save-btn');
            const editButton = document.getElementById('edit-btn');
            const header = document.getElementById('titular');
            const editBTN = document.getElementById('edit-btn');
            // Toggle disable property for fields
            fields.forEach(field => {
                field.disabled = !field.disabled;
            });

            // Show/hide save button
            saveButton.style.display = saveButton.style.display === 'block' ? 'none' : 'block';

            // Change header text
            if (saveButton.style.display === 'block') {
                header.textContent = "Editar Información del Perfil";
                editBTN.textContent = "Cancelar Edicion"
            } else {
                header.textContent = "Ver Información del Perfil";
                editBTN.textContent = "Editar Informacion"
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h1 id="titular">Ver Información del Perfil</h1>
        <form action="../0-php/actualizarPerfil.php" method="POST">
            <label for="correo">Correo:</label>
            <input type="email" id="correo" name="correo" value="<?= htmlspecialchars($user['correo']) ?>" class="editable" disabled required>

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($user['nombre']) ?>" class="editable" disabled required>

            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" value="<?= htmlspecialchars($user['telefono']) ?>" class="editable" disabled required>

            <label for="edad">Edad:</label>
            <input type="number" id="edad" name="edad" value="<?= htmlspecialchars($user['edad']) ?>" class="editable" disabled required>

            <button type="button" id="edit-btn" onclick="toggleEdit()">Editar Información</button>
            <button type="submit" id="save-btn" style="display: none;">Guardar Cambios</button>
        </form>
        <button class="return-button" onclick="window.location.href='panelUsuario.php'">Volver</button>
    </div>
</body>
</html>
