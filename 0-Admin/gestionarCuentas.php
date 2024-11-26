<?php
session_start();
if (!isset($_SESSION['tipo_cuenta']) || $_SESSION['tipo_cuenta'] !== 'Admin') {
    header("Location: ../1-Sesion/login.html");
    exit();
}

include '../0-php/conexion.php'; // Database connection

// Fetch users and active patients data
$sql = "
    SELECT u.*, COUNT(up.paciente_id) AS num_active_patients
    FROM Usuarios u
    LEFT JOIN usuario_paciente up ON u.usuario_id = up.usuario_id AND up.activo = 1
    GROUP BY u.usuario_id
";
$result = $con->query($sql);

$sql2 = "
    SELECT p.*, u.correo AS usuario_correo
    FROM Pacientes p
    LEFT JOIN usuario_paciente up ON p.paciente_id = up.paciente_id
    LEFT JOIN Usuarios u ON up.usuario_id = u.usuario_id
";
$result2 = $con->query($sql2);

// Fetch Medico accounts (where tipo_cuenta = 'Medico')
$sql3 = "
    SELECT * FROM Administrativo
    WHERE tipo_cuenta = 'Medico'
";
$result3 = $con->query($sql3);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Cuentas y Pacientes</title>
    <link rel="stylesheet" href="../CSS/gestionCuentas.css">
</head>
<body>
    <header>
        <h1>Gestión de Cuentas y Pacientes</h1>
        <p>Desde esta página, puedes gestionar cuentas de usuarios, pacientes y médicos.</p>
    </header>

    <main>
        <section class="accounts-section">
            <h2>Cuentas de Usuarios</h2>
            <table>
                <thead>
                    <tr>
                        <th>Correo</th>
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Estado de Pago</th>
                        <th>Pacientes Activos</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $user['correo'] ?></td>
                            <td><?= $user['nombre'] ?></td>
                            <td><?= $user['telefono'] ?></td>
                            <td><?= $user['Estado_Pago'] ?></td>
                            <td><?= $user['num_active_patients'] ?></td>
                            <td>
                                <a href="verDetalles.php?ID=<?= $user['usuario_id'] ?>">Ver Detalles</a>
                                <a href="../0-php/borrarCuenta.php?user_id=<?= $user['usuario_id'] ?>" class="delete-button">Eliminar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>

        <section class="patients-section">
            <h2>Pacientes</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Edad</th>
                        <th>Género</th>
                        <th>Correo del Usuario Asociado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($patient = $result2->fetch_assoc()): ?>
                        <tr>
                            <td><?= $patient['nombre'] ?></td>
                            <td><?= $patient['edad'] ?></td>
                            <td><?= $patient['genero'] ?></td>
                            <td><?= $patient['usuario_correo'] ?: 'No asignado' ?></td>
                            <td>
                                <a href="../0-php/borrarPaciente.php?patient_id=<?= $patient['paciente_id'] ?>" class="delete-button">Eliminar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>

        <!-- New Section for Medico Accounts -->
        <section class="medico-accounts-section">
            <h2>Cuentas de Médicos</h2>
            <table>
                <thead>
                    <tr>
                        <th>Correo</th>
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($medico = $result3->fetch_assoc()): ?>
                        <tr>
                            <td><?= $medico['correo'] ?></td>
                            <td><?= $medico['nombre'] ?></td>
                            <td><?= $medico['telefono'] ?></td>
                            <td>
                                <a href="verDetallesMedico.php?medico_id=<?= $medico['ID'] ?>">Ver Detalles</a>
                                <a href="../0-php/borrarMedico.php?medico_id=<?= $medico['ID'] ?>" class="delete-button">Eliminar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>

        <button class="return-button" onclick="window.location.href='panelAdmin.php'">Volver al Panel de Administración</button>
    </main>
</body>
</html>
