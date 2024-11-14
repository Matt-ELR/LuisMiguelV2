<?php
session_start();
if ($_SESSION['account_type'] !== 'paciente') {
    header("Location: ../Sesion/login.html"); // Redirect if not an admin
    exit();
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin</title>
</head>
<body>

    <h1>Admin Dashboard</h1>
    <p>Welcome, <?php echo $_SESSION['username']; ?>! This page is for paciente only.</p>
    
</body>
</html>