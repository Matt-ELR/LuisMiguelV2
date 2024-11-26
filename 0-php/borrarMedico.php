<?php
// Include the database connection
include 'conexion.php';

// Get the medico_id from the URL parameter
if (isset($_GET['medico_id'])) {
    $medico_id = $_GET['medico_id'];

    // Delete query for the Medic account
    $sql = "DELETE FROM Administrativo WHERE ID = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $medico_id);

    if ($stmt->execute()) {
        // If successful, redirect back to the account management page
        header("Location: gestionarCuentas.php?success=1");
    } else {
        // If there was an error, display a message
        echo "<script>alert('Error al eliminar el médico. Intente nuevamente.'); window.location.href='gestionarCuentas.php';</script>";
    }

    // Close the statement and connection
    $stmt->close();
} else {
    // If no medico_id is provided
    echo "<script>alert('ID de médico no proporcionado.'); window.location.href='gestionarCuentas.php';</script>";
}

$con->close();
?>
