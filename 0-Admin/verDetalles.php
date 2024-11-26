<?php
session_start();
if (!isset($_SESSION['tipo_cuenta']) || $_SESSION['tipo_cuenta'] !== 'Admin') {
    header("Location: ../1-Sesion/login.html");
    exit();
}

include '../0-php/conexion.php'; // Database connection

// Check if ID is passed in the URL
if (isset($_GET['ID'])) {
    $userId = $_GET['ID'];

    // Fetch user details by ID
    $sql = "SELECT * FROM Usuarios WHERE usuario_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $userId); // Bind the ID parameter to the query
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Check if user exists
    if (!$user) {
        echo "Usuario no encontrado";
        exit();
    }
} else {
    echo "ID no proporcionado";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Usuario</title>
    <link rel="stylesheet" href="../CSS/gestionCuentas.css">
</head>
<body>
    <header>
        <h1>Detalles del Usuario</h1>
        <p>Ver información completa del usuario.</p>
    </header>

    <main>
        <section>
            <h2>Información del Usuario</h2>
            <table>
                <tr>
                    <th>Correo</th>
                    <td><?= $user['correo'] ?></td>
                </tr>
                <tr>
                    <th>Nombre</th>
                    <td><?= $user['nombre'] ?></td>
                </tr>
                <tr>
                    <th>Teléfono</th>
                    <td><?= $user['telefono'] ?></td>
                </tr>
                <tr>
                    <th>Estado de Pago</th>
                    <td><?= $user['Estado_Pago'] ?></td>
                </tr>
                <!-- You can add more fields here -->
            </table>

            <button class="return-button" onclick="window.location.href='gestionarCuentas.php'">Volver al gestion de cuentas</button>
        </section>
    </main>
</body>
</html>
