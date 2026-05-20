<?php

class Especialidad {

    private $conexion;

    public function __construct($conexion){
        $this->conexion = $conexion;
    }

    // ==============================
    // CREAR ESPECIALIDAD (CREATE)
    // ==============================
    public function crear($nombre_especialidad, $descripcion = null){
        try {
            $sql = "
            INSERT INTO especialidades (
                nombre_especialidad,
                descripcion
            )
            VALUES (?, ?)
            ";

            $stmt = $this->conexion->prepare($sql);

            return $stmt->execute([
                $nombre_especialidad,
                $descripcion
            ]);
        } catch (PDOException $e) {
            throw new Exception("Error al crear especialidad: " . $e->getMessage());
        }
    }

    // ==============================
    // OBTENER TODAS LAS ESPECIALIDADES (READ)
    // ==============================
    public function obtenerTodas(){
        try {
            $sql = "
            SELECT * FROM especialidades
            ORDER BY nombre_especialidad ASC
            ";

            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener especialidades: " . $e->getMessage());
        }
    }

    // ==============================
    // OBTENER ESPECIALIDAD POR ID (READ)
    // ==============================
    public function obtenerPorId($id){
        try {
            $sql = "
            SELECT * FROM especialidades
            WHERE id_especialidad = ?
            ";

            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$id]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener especialidad: " . $e->getMessage());
        }
    }

    // ==============================
    // ACTUALIZAR ESPECIALIDAD (UPDATE)
    // ==============================
    public function actualizar($id, $nombre_especialidad, $descripcion = null){
        try {
            $sql = "
            UPDATE especialidades
            SET nombre_especialidad = ?,
                descripcion = ?
            WHERE id_especialidad = ?
            ";

            $stmt = $this->conexion->prepare($sql);

            return $stmt->execute([
                $nombre_especialidad,
                $descripcion,
                $id
            ]);
        } catch (PDOException $e) {
            throw new Exception("Error al actualizar especialidad: " . $e->getMessage());
        }
    }

    // ==============================
    // ELIMINAR ESPECIALIDAD (DELETE)
    // ==============================
    public function eliminar($id){
        try {
            $sql = "
            DELETE FROM especialidades
            WHERE id_especialidad = ?
            ";

            $stmt = $this->conexion->prepare($sql);

            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            throw new Exception("Error al eliminar especialidad: " . $e->getMessage());
        }
    }

    // ==============================
    // BUSCAR ESPECIALIDAD POR NOMBRE
    // ==============================
    public function buscarPorNombre($nombre){
        try {
            $sql = "
            SELECT * FROM especialidades
            WHERE nombre_especialidad ILIKE ?
            ORDER BY nombre_especialidad ASC
            ";

            $stmt = $this->conexion->prepare($sql);
            $stmt->execute(['%' . $nombre . '%']);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al buscar especialidades: " . $e->getMessage());
        }
    }

    // ==============================
    // CONTAR ESPECIALIDADES
    // ==============================
    public function contar(){
        try {
            $sql = "SELECT COUNT(*) as total FROM especialidades";

            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();

            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado['total'];
        } catch (PDOException $e) {
            throw new Exception("Error al contar especialidades: " . $e->getMessage());
        }
    }

    // ==============================
    // OBTENER CANTIDAD DE MÉDICOS POR ESPECIALIDAD
    // ==============================
    public function obtenerMedicosPorEspecialidad(){
        try {
            $sql = "
            SELECT 
                e.id_especialidad,
                e.nombre_especialidad,
                COUNT(m.id_medico) as cantidad_medicos
            FROM especialidades e
            LEFT JOIN medicos m ON e.id_especialidad = m.id_especialidad
            GROUP BY e.id_especialidad, e.nombre_especialidad
            ORDER BY e.nombre_especialidad ASC
            ";

            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener especialidades: " . $e->getMessage());
        }
    }
}

?>
