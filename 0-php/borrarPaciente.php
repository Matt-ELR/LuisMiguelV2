<?php
// Include the database connection
include '../0-php/conexion.php';

// Get the paciente_id from the URL parameter
if (isset($_GET['paciente_id'])) {
    $paciente_id = $_GET['paciente_id'];

    // Delete query for the Patient
    $sql = "DELETE FROM pacientes WHERE paciente_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $paciente_id);

    if ($stmt->execute()) {
        // If successful, redirect back to the account management page
        header("Location: gestionarPacientes.php?success=1");
    } else {
        // If there was an error, display a message
        echo "<script>alert('Error al eliminar el paciente. Intente nuevamente.'); window.location.href='gestionarPacientes.php';</script>";
    }

    // Close the statement and connection
    $stmt->close();
} else {
    // If no paciente_id is provided
    echo "<script>alert('ID de paciente no proporcionado.'); window.location.href='gestionarPacientes.php';</script>";
}

$con->close();
?>
