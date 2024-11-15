<?php
session_start();
session_destroy(); // Destroy the session
header("Location: ../1-Sesion/login.html"); // Redirect to login page
exit();
?>
