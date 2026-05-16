<?php
session_start();
require_once __DIR__ . '/../../middleware/AuthMiddleware.php';

if($_SESSION['rol'] !== 'doctor'){
    header("Location: ../auth/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title> Doctor</title>
    <link rel="stylesheet" href="../../../public/css/styles.css">
</head>
<body>
<?php include '../layouts/sidebar.php'; ?>
<div class="contenido">
    <h1>Bienvenido Dr: <?= $_SESSION['usuario'] ?></h1>
</div>
</body>
</html>