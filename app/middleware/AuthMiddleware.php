<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario'])) {
    //para que la pagina principal carge bien 
    header("Location: ../auth/login.php");
    exit();
}

function validarRol($rolPermitido) {
    if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== $rolPermitido) {
        echo "Acceso denegado. No tienes permisos para ver esta sección.";
        exit();
    }
}
?>