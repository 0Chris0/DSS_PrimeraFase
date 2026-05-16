<?php

class Usuario {

    // VARIABLE DE CONEXIÓN PDO
    // ==============================

    private $conexion;



    // ==============================
    // CONSTRUCTOR
    // Recibe la conexión a la BD
    // ==============================

    public function __construct($conexion){

        $this->conexion = $conexion;
    }

    // REGISTRAR USUARIO
    // INSERT INTO usuarios
    public function registrar(
        $correo,
        $password,
        $rol
    ){

        // Consulta SQL
        $sql = "
        INSERT INTO usuarios(
            correo,
            password,
            rol
        )
        VALUES(?,?,?)
        ";


        // Preparar consulta PDO
        // Previene SQL Injection
        $stmt = $this->conexion->prepare($sql);


        // Ejecutar consulta
        return $stmt->execute([

            $correo,
            $password,
            $rol

        ]);
    }



    // ==============================
    // BUSCAR USUARIO POR CORREO
    // ==============================

    public function buscarCorreo($correo){

        // Consulta SQL
        $sql = "
        SELECT *
        FROM usuarios
        WHERE correo = ?
        ";


        // Preparar consulta
        $stmt = $this->conexion->prepare($sql);


        // Ejecutar consulta
        $stmt->execute([$correo]);


        // Retornar usuario encontrado
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

?>