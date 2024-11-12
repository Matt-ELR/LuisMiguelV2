<?php
include 'conexion.php';
$ID = $_REQUEST['ID'];
$del = $con -> query("DELETE FROM profesores WHERE ID = '$ID'");
if ($del) {
    echo "<script>
    location.href='../control.php';
    </script>";
} else {
    echo "<script>
    alert('El registro no pudo ser eliminado');
    location.href='../control.php';
    </script>";
}
$con->close();
?>