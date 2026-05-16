<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$host = "localhost";
$db = "citas_medicas";
$user = "root";
$pass = "";

try {

    $conexion = new PDO(
        "mysql:host=$host;dbname=$db;charset=utf8",
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