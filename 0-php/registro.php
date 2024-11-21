<?php
include 'conexion.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $nombre = $_POST['nombre'];
    $edad = $_POST['edad'];
    $contraseña = password_hash($_POST['contraseña'], PASSWORD_DEFAULT); // Hash the password
    $estado_pago = 'sin_realizar'; // Default value

    // Prepare SQL query to insert user data
    $sql = "INSERT INTO Usuarios (correo, telefono, nombre, edad, contraseña, Estado_pago) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $con->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sssiss", $correo, $telefono, $nombre, $edad, $contraseña, $estado_pago);

        if ($stmt->execute()) {
            echo "<script>
            alert('Registro exitoso. Por favor, inicie sesión.');
            window.location.href = '../1-Sesion/login.html';
            </script>";
        } else {
            echo "<script>
            alert('Error al registrar usuario. Intente nuevamente más tarde.');
            window.location.href = '../1-Sesion/registro.html';
            </script>";
        }

        $stmt->close();
    } else {
        die("Error en la preparación de la consulta: " . $con->error);
    }

    $con->close();
} else {
    header("Location: ../1-Sesion/registro.html");
    exit();
}
?>
