<?php
session_start();
include 'conexion.php'; // Conecta a la BD

// Consigue datos
$username = $_POST['username'];
$password = $_POST['password'];

// Retrieve user information from database
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && password_verify($password, $user['password'])) {
    // Successful login
    $_SESSION['username'] = $user['username'];
    $_SESSION['account_type'] = $user['account_type'];

    // Redirect based on account type
    if ($user['account_type'] === 'admin') {
        header("Location: admin_dashboard.php");
    } elseif ($user['account_type'] === 'user') {
        header("Location: user_dashboard.php");
    } else {
        header("Location: guest_dashboard.php");
    }
    exit();
} else {
    // Login failed
    echo "<script>
    alert('Invalid username or password!');
    location.href='../login.html';
    </script>";
}

// Close the database connection
$stmt->close();
$con->close();
?>
