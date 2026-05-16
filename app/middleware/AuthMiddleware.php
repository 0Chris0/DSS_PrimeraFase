<<?php
// Validación de sesiones 

if(!isset($_SESSION['usuario'])){
    header("Location: ../auth/login.php");
    exit();
}