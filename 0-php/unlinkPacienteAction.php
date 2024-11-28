<?php
session_start();
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['paciente_id'])) {
    $paciente_id = intval($_POST['paciente_id']);
    $medico_id = $_SESSION['ID'];

    // Delete from Medico-Paciente table
    $stmt = $con->prepare("DELETE FROM `Medico-Paciente` WHERE medico_id = ? AND paciente_id = ?");
    $stmt->bind_param("ii", $medico_id, $paciente_id);

    if ($stmt->execute()) {
        $message = "Paciente desvinculado con éxito.";
    } else {
        $message = "Error al desvincular paciente.";
    }

    $stmt->close();
    $con->close();

    // Redirect back to the main page
    header("Location: ../0-Medicos/linkPaciente.php");
    exit();
}
?>
