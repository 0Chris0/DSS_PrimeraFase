<?php
$host = "localhost";
$port = "3306"; // Usa 3307 si no pudiste liberar el puerto antes
$db = "clinica"; // El nombre de la base de datos que creamos con tus tablas
$user = "root";
$pass = "";

try {
    $conexion = new PDO(
        "mysql:host=$host;port=$port;dbname=$db",
        $user,
        $pass
    );

    $conexion->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

} catch(PDOException $e){
    die("Error de conexión: " . $e->getMessage());
}
?>
