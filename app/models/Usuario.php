<?php
class Usuario {
    private $conexion;

    public function __construct($conexion){
        $this->conexion = $conexion;
    }

    public function registrar($correo, $password, $rol){
    // Asegúrate de que los nombres de columnas sean los reales de tu tabla
    $sql = "INSERT INTO usuarios (username, correo, password, rol) VALUES (?, ?, ?, ?)";
    $stmt = $this->conexion->prepare($sql);
    // Pasamos $correo dos veces: una para username y otra para correo
    return $stmt->execute([$correo, $correo, $password, $rol]);
}

    public function obtenerPorCorreo($correo) {
        $sql = "SELECT * FROM usuarios WHERE correo = :correo";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute(['correo' => $correo]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>