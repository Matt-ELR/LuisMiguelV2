<?php
session_start();
session_destroy(); // Destroy the session
header("Location: ../Sesion/login.html"); // Redirect to login page
exit();
?>
