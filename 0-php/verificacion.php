<?php
session_start();
include 'conexion.php'; // Include database connection

// Get user input
$correo = $_POST['correo'];
$contraseña = $_POST['contraseña'];

// Check in the first table (Usuarios)
$sql = "SELECT * FROM Usuarios WHERE correo = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && password_verify($contraseña, $user['contraseña'])) { // Verify the hashed password
    // Successful login for Usuarios table
    $_SESSION['correo'] = $user['correo'];
    $_SESSION['nombre'] = $user['nombre'];
    $_SESSION['usuario_id'] = $user['usuario_id'];
    $_SESSION['username'] = $user['nombre']; // Assuming you want to display the name

    // Redirect to the default user panel
    header("Location: ../3-Usuario/PanelUsuario.php");
    exit();
    
} else {
    // If not found in the first table, check the secondary table (e.g., Medicos)
    $sql2 = "SELECT * FROM Medicos WHERE correo = ?";
    $stmt2 = $con->prepare($sql2);
    $stmt2->bind_param("s", $correo);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    $medico = $result2->fetch_assoc();

    if ($medico && password_verify($contraseña, $medico['contraseña'])) { // Verify the hashed password
        // Successful login for Medicos table
        $_SESSION['correo'] = $medico['correo'];
        $_SESSION['nombre'] = $medico['nombre'];
        $_SESSION['ID'] = $medico['medico_id']; // Assuming ID field is medico_id
        $_SESSION['tipo_cuenta'] = $medico['tipo_cuenta']; // Should be 'Medico' or 'Admin'

        // Redirect based on tipo_cuenta
        if ($medico['tipo_cuenta'] === 'Medico') {
            header("Location: ../4-Medico/PanelMedico.php");
        } elseif ($medico['tipo_cuenta'] === 'Admin') {
            header("Location: ../5-Admin/PanelAdmin.php");
        }
        exit();
    } else {
        // Login failed for both tables
        echo "<script>
        alert('Correo o contraseña inválidos!');
        location.href='../1-Sesion/login.html';
        </script>";
    }
}

// Close database connections
$stmt->close();
if (isset($stmt2)) $stmt2->close();
$con->close();
?>
