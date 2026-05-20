<?php

class Paciente {

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

    // ==============================
    // CREAR PACIENTE (CREATE)
    // Se modificó para recibir e insertar las notas
    // ==============================
    public function crear($nombre, $apellido, $correo, $telefono, $fecha_nacimiento, $genero, $direccion, $numero_identificacion, $notas = null){
        try {
            $sql = "
            INSERT INTO pacientes (
                nombre_paciente,
                apellido_paciente,
                correo_paciente,
                telefono_paciente,
                fecha_nacimiento,
                genero,
                direccion,
                numero_identificacion,
                notas
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ";

            $stmt = $this->conexion->prepare($sql);

            return $stmt->execute([
                $nombre,
                $apellido,
                $correo,
                $telefono,
                $fecha_nacimiento,
                $genero,
                $direccion,
                $numero_identificacion,
                $notas
            ]);
        } catch (PDOException $e) {
            throw new Exception("Error al crear paciente: " . $e->getMessage());
        }
    }

    // ==============================
    // OBTENER TODOS LOS PACIENTES (READ)
    // ==============================
    public function obtenerTodos(){
        try {
            $sql = "
            SELECT * FROM pacientes
            ORDER BY fecha_registro DESC
            ";

            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener pacientes: " . $e->getMessage());
        }
    }

    // ==============================
    // OBTENER PACIENTE POR ID (READ)
    // ==============================
    public function obtenerPorId($id){
        try {
            $sql = "
            SELECT * FROM pacientes
            WHERE id_paciente = ?
            ";

            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$id]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener paciente: " . $e->getMessage());
        }
    }

    // ==============================
    // ACTUALIZAR PACIENTE (UPDATE)
    // Se añade el campo notas por si se edita en el futuro
    // ==============================
    public function actualizar($id, $nombre, $apellido, $correo, $telefono, $fecha_nacimiento, $genero, $direccion, $notas = null){
        try {
            $sql = "
            UPDATE pacientes
            SET nombre_paciente = ?,
                apellido_paciente = ?,
                correo_paciente = ?,
                telefono_paciente = ?,
                fecha_nacimiento = ?,
                genero = ?,
                direccion = ?,
                notas = ?
            WHERE id_paciente = ?
            ";

            $stmt = $this->conexion->prepare($sql);

            return $stmt->execute([
                $nombre,
                $apellido,
                $correo,
                $telefono,
                $fecha_nacimiento,
                $genero,
                $direccion,
                $notas,
                $id
            ]);
        } catch (PDOException $e) {
            throw new Exception("Error al actualizar paciente: " . $e->getMessage());
        }
    }

    // ==============================
    // ELIMINAR PACIENTE (DELETE)
    // ==============================
    public function eliminar($id){
        try {
            $sql = "
            DELETE FROM pacientes
            WHERE id_paciente = ?
            ";

            $stmt = $this->conexion->prepare($sql);

            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            throw new Exception("Error al eliminar paciente: " . $e->getMessage());
        }
    }

    // ==============================
    // BUSCAR PACIENTE POR IDENTIFICACIÓN
    // ==============================
    public function buscarPorIdentificacion($numero_identificacion){
        try {
            $sql = "
            SELECT * FROM pacientes
            WHERE numero_identificacion = ?
            ";

            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$numero_identificacion]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al buscar paciente: " . $e->getMessage());
        }
    }

    // ==============================
    // CONTAR PACIENTES
    // ==============================
    public function contar(){
        try {
            $sql = "SELECT COUNT(*) as total FROM pacientes";

            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();

            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado['total'];
        } catch (PDOException $e) {
            throw new Exception("Error al contar pacientes: " . $e->getMessage());
        }
    }
}

?>
