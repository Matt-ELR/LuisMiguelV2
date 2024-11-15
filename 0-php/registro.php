<?php
include 'conexion.php'; // Conecta a la BD

// Recupera y sanitiza los datos de entrada
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];
$nombre = $_POST['nombre'];
$edad = $_POST['edad'];
$contraseña = $_POST['contraseña']; // Get the password from the form

// Hash the password
$hashed_password = password_hash($contraseña, PASSWORD_BCRYPT);

// Utiliza una declaración preparada para prevenir la inyección SQL
$stmt = $con->prepare("INSERT INTO Usuarios (correo, telefono, nombre, edad, contraseña) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $correo, $telefono, $nombre, $edad, $hashed_password); // Use the hashed password

// Ejecuta la declaración y verifica si fue exitosa
if ($stmt->execute()) {
    echo "<script>
    alert('Se ha añadido el usuario');
    location.href='../1-Sesion/login.html';
    </script>";
} else {
    echo "<script>
    alert('El registro no pudo ser añadido');
    location.href='../1-Sesion/FormRegistro.html';
    </script>";
}

// Cierra la declaración y la conexión a la base de datos
$stmt->close();
$con->close();
?>