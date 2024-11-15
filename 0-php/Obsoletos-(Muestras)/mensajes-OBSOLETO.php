<?php
include 'conexion.php';
$Nombre=$_POST['Nombre'];
$Email=$_POST['Email'];
$Mensaje=$_POST['Mensaje'];
$insert=$con -> query("INSERT INTO `Mensajes` (`Nombre`,`Email`,`Mensaje`)
VALUES ('$Nombre','$Email','$Mensaje')");
if($insert){
    echo "<script>
    alert('Muchas gracias por contactarnos, en breve nos comunicaremos contigo.');
    location.href='../contacto.html';
    </script>";
}else{
    echo "<script>
    alert('No se guardo ningun registro');
    location.href='../contacto.html';
    </script>";
}
$con->close();