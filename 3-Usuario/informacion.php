<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Telefono</th>
                        <th>Edad</th>
                        <th>Editar</th>
                    </tr>
                    <?php
                    include '../0-php/conexion.php';
                    $slec = $con->query("SELECT * FROM usuarios");
                    while ($fila = $slec->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $fila['usuario_id'] ?></td>
                            <td><?php echo $fila['nombre'] ?></td>
                            <td><?php echo $fila['correo'] ?></td>
                            <td><?php echo $fila['telefono'] ?></td>
                            <td><?php echo $fila['edad'] ?></td>
                            <td><a href="actualizarpro.php?id=<?php echo $fila['id'] ?>">Editar</a></td>
                        </tr>
                    <?php } ?>
                </table>
        
</body>
</html>