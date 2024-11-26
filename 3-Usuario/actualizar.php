<?php  include '../0-php/conexion.php';
$Usuario_id = $_REQUEST['usuario_id'];
$select = $con -> query("SELECT * FROM usuarios WHERE usuario_id='$Usuario_id'");
if ($fila = $select -> fetch_assoc()); {
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Datos</title>  
</head>
<body>
    <form action="basepro.php" method="post">
        <input type="hidden" name="id" value="<?php echo $id ?>">
        <input type="text" name='nombre' placeholder="Nombre" value="<?php echo $fila['nombre']?>"><br>
        <input type="text" name='correo' placeholder="Edad" value="<?php echo $fila['correo']?>"><br>
        <input type="text" name='telefono' placeholder="Tel" id="xd" value="<?php echo $fila['telefono']?>"><br>
        <input type="text" name='edad' placeholder="Edad" id="xd" value="<?php echo $fila['edad']?>"><br>
        <input type="submit" value="Actualizar">
    </form><br><br>
</body>
</html>