<?php
session_start();
if (!isset($_SESSION['tipo_cuenta']) || $_SESSION['tipo_cuenta'] !== 'Admin') {
    header("Location: ../1-Sesion/login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cuenta Administrativo</title>
    <link rel="stylesheet" href="../CSS/cuentasAdmin.css">
</head>
<body>
    <header>
        <h1>Crear Cuenta Administrativo</h1>
        <p>Utilice este formulario para registrar cuentas de médicos o administradores en la base de datos.</p>
    </header>

    <main>
        <form action="../0-php/cuentasAdmin.php" method="POST" class="form">
            <div class="form-group">
                <label for="correo">Correo:</label>
                <input type="email" id="correo" name="correo" placeholder="Ingrese el correo" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="text" id="telefono" name="telefono" placeholder="Ingrese el teléfono" required>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" placeholder="Ingrese el nombre completo" required>
            </div>
            <div class="form-group">
                <label for="contraseña">Contraseña:</label>
                <input type="password" id="contraseña" name="contraseña" placeholder="Ingrese la contraseña" required>
            </div>
            <div class="form-group">
                <label for="tipo_cuenta">Tipo de Cuenta:</label>
                <select id="tipo_cuenta" name="tipo_cuenta" required>
                    <option value="" disabled selected>Seleccione un tipo</option>
                    <option value="Medico">Médico</option>
                    <option value="Admin">Administrador</option>
                </select>
            </div>
            <button type="submit" class="form-button">Crear Cuenta</button>
        </form>
        <button class="return-button" onclick="window.location.href='panelAdmin.php'">Volver al Panel de Administración</button>
    </main>
</body>
</html>
