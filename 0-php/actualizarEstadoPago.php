<?php
include 'conexion.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['usuario_id'], $_POST['accion'])) {
    $usuario_id = intval($_POST['usuario_id']);
    $accion = $_POST['accion'];

    // Determine the new Estado_Pago based on action
    $nuevoEstado = '';
    if ($accion === 'aceptar') {
        $nuevoEstado = 'aceptado';
    } elseif ($accion === 'rechazar') {
        $nuevoEstado = 'sin_realizar';
    } elseif ($accion === 'pendiente') {
        $nuevoEstado = 'pendiente';
    } else {
        die("Acción inválida.");
    }

    // Update Estado_Pago in the database
    $sql = "UPDATE Usuarios SET Estado_Pago = ? WHERE usuario_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("si", $nuevoEstado, $usuario_id);

    if ($stmt->execute()) {
        echo "<script>
        alert('Se ha actualizado.');
        location.href='../0-Admin/validarPago.php';
        </script>";
    } else {
        echo "<script>
        alert('Error al actualizar el estado de pago.');
        location.href='../0-Admin/validarPago.php';
        </script>";
    }

    $stmt->close();
}
$con->close();
?>
