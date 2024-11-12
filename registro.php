<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>
<body>
    <form action="register.php" method="POST">
        <label>Usuario:</label>
        <input type="text" name="username" required>
        <label>Contraseña:</label>
        <input type="password" name="password" required>
        <label>Tipo de cuenta:</label>
        <select name="account_type">
            <option value="Paciente">Paciente</option>
            <option value="Administrador">Administrador</option>
            <option value="Medico">Medico</option>
        </select>
        <button type="submit">Registrarse</button>
    </form>
</body>
</html>
