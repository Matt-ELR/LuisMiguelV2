<?php
session_start();

// Database connection parameters
include 'conexion.php';

// Create a new PDO instance
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Database connection failed: ' . $e->getMessage();
    exit();
}

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the transaction ID and user ID from the POST data
    $pago_id = $_POST['pago_id'];
    $userId = $_POST['userId'];
    $amount = $_POST['amount'];
    $status = $_POST['status'];

    // Prepare the SQL statement to insert the payment record
    $stmt = $pdo->prepare("INSERT INTO pagos (usuario_id, fecha_pago, monto, estado, TokenPago) VALUES (?, NOW(), ?, ?, ?)");

    // Execute the statement
    if ($stmt->execute([$userId, $amount, $status, $transactionId])) {
        echo 'Payment recorded successfully.';
    } else {
        echo 'Failed to insert payment record.';
    }
} else {
    echo 'Invalid request method.';
}
?>