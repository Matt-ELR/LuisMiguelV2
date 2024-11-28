<?php
session_start();
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['paciente_id'])) {
    $paciente_id = intval($_POST['paciente_id']);
    $medico_id = $_SESSION['ID'];

    // Insert into Medico-Paciente table
    $stmt = $con->prepare("INSERT INTO `Medico-Paciente` (medico_id, paciente_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $medico_id, $paciente_id);

    if ($stmt->execute()) {
        $message = "Paciente vinculado con éxito.";
    } else {
        $message = "Error al vincular paciente. Puede que ya esté vinculado.";
    }

    $stmt->close();
    $con->close();

    // Redirect back to the main page
    header("Location: ../0-Medicos/linkPaciente.php");
    exit();
}
?>
