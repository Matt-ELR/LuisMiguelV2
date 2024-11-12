<?php
include 'conexion.php';
$Nombre=$_POST['Nombre'];
$Apellido=$_POST['Apellido'];
$Estudios=$_POST['Estudios'];
$Informacion=$_POST['Informacion'];
$Imagen = $_FILES['foto']['tmp_name'];
$Imagen_base64 = base64_encode(file_get_contents($Imagen));
$insert=$con -> query("INSERT INTO `Profesores` (`Nombre`,`Apellido`, `Estudios`, `Informacion`, `Imagen`)
VALUES ('$Nombre','$Apellido','$Estudios', '$Informacion','$Imagen_base64')");
if($insert){
    echo "<script>
    alert('Informacion añadida.');
    location.href='../control.php';
    </script>";
}else{
    echo "<script>
    alert('No se guardo ningun registro');
    location.href='../control.php';
    </script>";
}
$con->close();