<?php
session_start();

// Check if usuario_id is set in the session
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../1-Sesion/login.html"); // Redirect if not logged in
    exit();
}

// Include database connection
include 'conexion.php'; // Adjusted path to the database connection file

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario_id = $_SESSION['usuario_id'];
    $nombre = $_POST['nombre'];
    $edad = $_POST['edad'];
    $genero = $_POST['genero'];
    $altura = $_POST['altura'];
    $peso = $_POST['peso'];
    $nivel_erc = $_POST['nivel_erc']; // Assuming this field is also required
    $comida_favorita = $_POST['comida_favorita']; // Assuming this field is also required
    $disgustos = $_POST['disgustos']; // Assuming this field is also required

    // Insert new patient into Pacientes table
    $stmt = $con->prepare("
        INSERT INTO Pacientes (nombre, edad, genero, altura, peso, nivel_erc, comida_favorita, disgustos)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("sissssss", $nombre, $edad, $genero, $altura, $peso, $nivel_erc, $comida_favorita, $disgustos);
    
    if ($stmt->execute()) {
        $paciente_id = $con->insert_id; // Get the last inserted paciente_id

        // Link the new patient to the user in Usuario_Paciente table
        $stmt = $con->prepare("
            INSERT INTO Usuario_Paciente (usuario_id, paciente_id, activo)
            VALUES (?, ?, TRUE)
        ");
        $stmt->bind_param("ii", $usuario_id, $paciente_id);
        $stmt->execute();

        // Redirect to the dashboard or another page after successful insertion
        header("Location: ../3-Usuario/PanelUsuario.php"); // Adjust the redirect as needed
        exit();
    } else {
        $error = "Error al agregar el paciente: " . $stmt->error;
    }
}
?>