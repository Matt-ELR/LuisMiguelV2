<?php
session_start();
include 'conexion.php'; // Include database connection

// Ensure the script is accessed only via form submission
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../1-Sesion/login.html");
    exit();
}

// Check if the user is logged in
if (!isset($_SESSION['usuario_id'])) {
    die("Access denied: You must be logged in to perform this action.");
}

// Check if a file was uploaded
if (isset($_FILES['comprobante']) && $_FILES['comprobante']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['comprobante'];

    // Validate file type (accepting images and PDFs)
    $allowedTypes = ['image/jpg', 'image/jpeg', 'image/png', 'application/pdf'];
    if (!in_array($file['type'], $allowedTypes)) {
        die("Invalid file type. Only JPEG, PNG, or PDF files are allowed.");
    }

    // Limit file size (e.g., 40MB max)
    if ($file['size'] > 40 * 1024 * 1024) {
        die("File too large. Maximum size allowed is 40MB.");
    }

    // Read file content as binary
    $fileContent = file_get_contents($file['tmp_name']);
    if ($fileContent === false) {
        die("Error reading the uploaded file. Please try again.");
    }

    // Update the database with the uploaded file
    $sql = "UPDATE Usuarios SET Comprobante = ? WHERE usuario_id = ?";
    $stmt = $con->prepare($sql);

    if (!$stmt) {
        die("Failed to prepare the statement: " . $con->error);
    }

    // Bind the binary data and user ID
    $stmt->bind_param("bi", $fileContent, $_SESSION['usuario_id']); // 'b' for binary data, 'i' for integer

    // Send the binary data
    $stmt->send_long_data(0, $fileContent);

    // Execute the statement
    if ($stmt->execute()) {
        // Update 'Estado_pago' to 'pendiente'
        $sql2 = "UPDATE Usuarios SET Estado_pago = 'pendiente' WHERE usuario_id = ?";
        $stmt2 = $con->prepare($sql2);

        if (!$stmt2) {
            die("Failed to prepare the second statement: " . $con->error);
        }

        $stmt2->bind_param("i", $_SESSION['usuario_id']);
        if ($stmt2->execute()) {
            echo "<script>
            alert('Comprobante de pago recibido. Espere a que algún administrador lo valide para ganar acceso a la página web. Esto puede tardar entre 1 y 2 días laborales.');
            location.href='../1-Sesion/login.html';
            </script>";
        } else {
            echo "<script>
            alert('El comprobante se subió, pero ocurrió un error al actualizar el estado de pago. Por favor, contacte al soporte.');
            location.href='../1-Sesion/login.html';
            </script>";
        }
        $stmt2->close();
    } else {
        echo "<script>
        alert('Ocurrió un error al subir su comprobante. Intente de nuevo más tarde.');
        location.href='../1-Sesion/login.html';
        </script>";
    }

    // Close resources
    $stmt->close();
    $con->close();
} else {
    // Handle missing or upload errors
    echo "<script>
    alert('No se subió archivo o hubo un error. Por favor intente de nuevo.');
    location.href='../1-Sesion/login.html';
    </script>";
}
?>
