<?php
session_start();

// Check if usuario_id is set in the session
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../1-Sesion/login.html"); // Redirect if not logged in
    exit();
}

// Include database connection
include 'conexion.php'; // Adjusted path to the database connection file

// Handle patient removal
if (isset($_GET ['paciente_id'])) {
    $paciente_id = intval($_GET['paciente_id']);
    $usuario_id = $_SESSION['usuario_id'];

    // Prepare the statement to remove the patient
    $stmt = $con->prepare("
        UPDATE Usuario_Paciente 
        SET activo = FALSE 
        WHERE paciente_id = ? AND usuario_id = ?
    ");
    $stmt->bind_param("ii", $paciente_id, $usuario_id);
    
    if ($stmt->execute()) {
        // Redirect back to the remove patient page with a success message
        header("Location: ../3-Usuario/PanelUsuario.php?message=Paciente eliminado con éxito");
    } else {
        // Redirect back with an error message
        header("Location: ../3-Usuario/PanelUsuario.php?error=Error al eliminar el paciente");
    }
    exit();
} else {
    // Redirect back if no patient ID is provided
    header("Location: ../3-Usuario/PanelUsuario.php?error=ID de paciente no válido");
    exit();
}