<?php
// Include the database connection
include '../0-php/conexion.php';

// Get the medico_id from the URL
if (isset($_GET['medico_id'])) {
    $medico_id = $_GET['medico_id'];

    // Fetch the medic details based on medico_id
    $sql = "SELECT * FROM Administrativo WHERE ID = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $medico_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $medico = $result->fetch_assoc();

    if (!$medico) {
        echo "<script>alert('Medico no encontrado.'); window.location.href='gestionarCuentas.php';</script>";
        exit();
    }

    // Close the statement
    $stmt->close();
} else {
    // If no medico_id is provided
    echo "<script>alert('ID de medico no proporcionado.'); window.location.href='gestionarCuentas.php';</script>";
    exit();
}

$con->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Medico</title>
    <link rel="stylesheet" href="../CSS/gestionCuentas.css">
</head>
<body>
    <div>
        <h1>Detalles del Médico</h1>
        <table> <!-- Added class for styling -->
            <tr>
                <th>Correo</th>
                <td><?= $medico['correo'] ?></td>
            </tr>
            <tr>
                <th>Nombre</th>
                <td><?= $medico['nombre'] ?></td>
            </tr>
            <tr>
                <th>Teléfono</th>
                <td><?= $medico['telefono'] ?></td>
            </tr>
            <tr>
                <th>Fecha de Creación</th>
                <td><?= $medico['fecha_creacion'] ?></td>
            </tr>
            <tr>
                <th>Tipo de Cuenta</th>
                <td><?= $medico['tipo_cuenta'] ?></td>
            </tr>
        </table>

        <button class="return-button" onclick="window.location.href='gestionarCuentas.php'">Volver a la Gestión de Cuentas</button>
    </div>
</body>
</html>
