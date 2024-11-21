<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../1-Sesion/login.html");
    exit();
}

// Ensure 'Estado_pago' is available in the session
if (!isset($_SESSION['Estado_Pago'])) {
    die("Estado de pago no disponible. Por favor, contacte al soporte.");
}

// Bank account details
$bankAccountDetails = [
    "dueño" => "Juan el que da miedo",
    "nCuenta" => "123456789012",
    "cantidad" => "$50.00 MXN"
];

// Display content based on Estado_pago
$estadoPago = $_SESSION['Estado_Pago'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de Pago</title>
</head>
<body>
    <h1>Detalles de Pago</h1>
    <?php if ($estadoPago === 'sin_realizar'): ?>
        <p><strong>Nombre del Dueño:</strong> <?php echo $bankAccountDetails['dueño']; ?></p>
        <p><strong>Número de Cuenta:</strong> <?php echo $bankAccountDetails['nCuenta']; ?></p>
        <p><strong>Cantidad a Pagar:</strong> <?php echo $bankAccountDetails['cantidad']; ?></p>

        <h2>Subir Comprobante de Pago</h2>
        <form action="../0-php/subircomprobante.php" method="POST" enctype="multipart/form-data">
            <label for="comprobante">Suba su comprobante de pago (JPG, JPEG, PNG o PDF):</label><br><br>
            <input type="file" name="comprobante" id="comprobante" accept=".jpg, .jpeg, .png, .pdf" required><br><br>
            <button type="submit">Subir</button>
        </form>
    <?php elseif ($estadoPago === 'pendiente'): ?>
        <p>El comprobante de pago ha sido recibido. Espere a que un administrador lo valide para obtener acceso a la página web. Esto puede tardar entre 1 y 2 días laborales.</p>
    <?php else: ?>
        <p>Estado de pago desconocido. Por favor, contacte al soporte.</p>
    <?php endif; ?>
</body>
</html>
