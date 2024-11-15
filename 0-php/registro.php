<?php
include 'conexion.php'; // Conecta a la BD

// Recupera y sanitiza los datos de entrada
$Usuario = $_POST['Usuario']; // Actualizado para que coincida con el nombre del campo del formulario
$Contraseña = password_hash($_POST['contraseña'], PASSWORD_BCRYPT); // Hashea la contraseña
$tipoCuenta = $_POST['tipoCuenta'];

// Utiliza una declaración preparada para prevenir la inyección SQL
$stmt = $con->prepare("INSERT INTO users (username, password, account_type) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $Usuario, $Contraseña, $tipoCuenta);

// Ejecuta la declaración y verifica si fue exitosa
if ($stmt->execute()) {
    echo "<script>
    alert('Se ha añadido el usuario');
    location.href='../1-Sesion/FormRegistro.html';
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