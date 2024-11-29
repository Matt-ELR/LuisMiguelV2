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

    // Function to assign a unique numero_control
    function getNewControlNumber($medico_id, $con) {
        $sql = "SELECT MAX(numero_control) AS max_control FROM `medico-paciente` WHERE medico_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $medico_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['max_control'] ? $result['max_control'] + 1 : 1;
    }

    $numero_control = getNewControlNumber($medico_id, $con);

    // Insert into medico-paciente
    $sqlLink = "INSERT INTO `medico-paciente` (medico_id, paciente_id, numero_control) VALUES (?, ?, ?)";
    $stmtLink = $con->prepare($sqlLink);
    $stmtLink->bind_param("iii", $medico_id, $paciente_id, $numero_control);

    if ($stmtLink->execute()) {
        // Update numero_control in pacientes
        $sqlUpdate = "UPDATE pacientes SET numero_control = ? WHERE paciente_id = ?";
        $stmtUpdate = $con->prepare($sqlUpdate);
        $stmtUpdate->bind_param("ii", $numero_control, $paciente_id);
        $stmtUpdate->execute();
    }
}

header("Location: ../0-Medicos/linkpaciente.php");
exit();
