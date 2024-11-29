<?php
session_start();
if (!isset($_SESSION['ID'])) {
    header("Location: ../1-Sesion/login.html");
    exit();
}

require_once "conexion.php";

// Get the current medic's ID
$medico_id = $_SESSION['ID'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['paciente_id'])) {
    $paciente_id = intval($_POST['paciente_id']);

    // Delete from medico-paciente
    $sqlUnlink = "DELETE FROM `medico-paciente` WHERE medico_id = ? AND paciente_id = ?";
    $stmtUnlink = $con->prepare($sqlUnlink);
    $stmtUnlink->bind_param("ii", $medico_id, $paciente_id);

    if ($stmtUnlink->execute()) {
        // Clear numero_control in pacientes
        $sqlUpdate = "UPDATE pacientes SET numero_control = NULL WHERE paciente_id = ?";
        $stmtUpdate = $con->prepare($sqlUpdate);
        $stmtUpdate->bind_param("i", $paciente_id);
        $stmtUpdate->execute();
    }
}

header("Location: ../0-Medicos/linkpaciente.php");
exit();
