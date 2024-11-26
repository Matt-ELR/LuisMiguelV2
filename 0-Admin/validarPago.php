<?php
session_start();
include '../0-php/conexion.php'; // Include the database connection

// Ensure the user is logged in and is an admin
if (!isset($_SESSION['tipo_cuenta']) || $_SESSION['tipo_cuenta'] !== 'Admin') {
    header("Location: ../1-Sesion/login.html");
    exit();
}

// Fetch pending submissions
$sqlPending = "SELECT usuario_id, correo, telefono, nombre, fecha_creacion, Estado_Pago, Comprobante FROM Usuarios WHERE Estado_Pago = 'pendiente'";
$resultPending = $con->query($sqlPending);

// Fetch accepted submissions
$sqlAccepted = "SELECT usuario_id, correo, telefono, nombre, fecha_creacion, Estado_Pago, Comprobante FROM Usuarios WHERE Estado_Pago = 'aceptado'";
$resultAccepted = $con->query($sqlAccepted);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validar Pagos</title>
    <link rel="stylesheet" href="../CSS/validarPago.css">
</head>
<body>
    <h1>Validar Comprobantes de Pago</h1>
    <p class="description">
        Verifique que los pagos con las referencias proporcionadas hayan sido aceptados por el banco <br>
        Acepte las solicitudes válidas y rechace aquellas con información incorrecta o sin evidencia de pago.
    </p>
    <button class="back-button" onclick="window.location.href='../0-Admin/panelAdmin.php'">Volver al Panel de Administrador</button>

    <!-- Section for Pending Submissions -->
    <section>
        <h2>Pagos Pendientes</h2>
        <p class="description">
                No olvide enviar un correo electronico a los comprobantes que rechace <br>
                para notificar al cliente de que no se valido su comprobante.   
        </p>
        <div class="entries">
            <?php if ($resultPending->num_rows > 0): ?>
                <?php while ($row = $resultPending->fetch_assoc()): ?>
                    <div class="entry">
                        <p><strong>Correo:</strong> <?php echo $row['correo']; ?></p>
                        <p><strong>Teléfono:</strong> <?php echo $row['telefono']; ?></p>
                        <p><strong>Nombre:</strong> <?php echo $row['nombre']; ?></p>
                        <p><strong>Fecha de Creación:</strong> <?php echo $row['fecha_creacion']; ?></p>
                        <div class="comprobante">
                            <strong>Comprobante:</strong><br>
                            <?php if ($row['Comprobante']): ?>
                                <img src="data:image/jpeg;base64,<?php echo base64_encode($row['Comprobante']); ?>" alt="Comprobante" />
                            <?php else: ?>
                                <p>No hay comprobante.</p>
                            <?php endif; ?>
                        </div>
                        <div class="actions">
                            <form action="../0-php/actualizarEstadoPago.php" method="POST">
                                <input type="hidden" name="usuario_id" value="<?php echo $row['usuario_id']; ?>">
                                <button type="submit" name="accion" value="aceptar" class="accept">Aceptar</button>
                                <button type="submit" name="accion" value="rechazar" class="reject">Rechazar</button>
                            </form>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No hay pagos pendientes.</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- Section for Accepted Submissions -->
    <section>
        <h2>Pagos Aceptados</h2>
        <p class="description">
                No olvide enviar un correo electronico a los comprobantes que acepte <br>
                para notificar al cliente de que ahora puede acceder a la pagina.   
        </p>
        <div class="entries">
            <?php if ($resultAccepted->num_rows > 0): ?>
                <?php while ($row = $resultAccepted->fetch_assoc()): ?>
                    <div class="entry">
                        <p><strong>Correo:</strong> <?php echo $row['correo']; ?></p>
                        <p><strong>Teléfono:</strong> <?php echo $row['telefono']; ?></p>
                        <p><strong>Nombre:</strong> <?php echo $row['nombre']; ?></p>
                        <p><strong>Fecha de Creación:</strong> <?php echo $row['fecha_creacion']; ?></p>
                        <div class="comprobante">
                            <strong>Comprobante:</strong><br>
                            <?php if ($row['Comprobante']): ?>
                                <img src="data:image/jpeg;base64,<?php echo base64_encode($row['Comprobante']); ?>" alt="Comprobante" />
                            <?php else: ?>
                                <p>No hay comprobante.</p>
                            <?php endif; ?>
                        </div>
                        <div class="actions">
                            <form action="../0-php/actualizarEstadoPago.php" method="POST">
                                <input type="hidden" name="usuario_id" value="<?php echo $row['usuario_id']; ?>">
                                <button type="submit" name="accion" value="pendiente" class="inspect">Revisar</button>
                            </form>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No hay pagos aceptados.</p>
            <?php endif; ?>
        </div>
    </section>
</body>
</html>
<?php
$con->close();
?>
