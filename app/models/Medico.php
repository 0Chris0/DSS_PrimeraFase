<?php

class Medico {

    private $conexion;

    public function __construct($conexion){
        $this->conexion = $conexion;
    }

    // ==============================
    // CREAR MÉDICO (CREATE)
    // ==============================
    public function crear($nombre_medico, $id_especialidad, $telefono = null){
        try {
            $sql = "
            INSERT INTO medicos (
                nombre_medico,
                id_especialidad,
                telefono
            )
            VALUES (?, ?, ?)
            ";

            $stmt = $this->conexion->prepare($sql);

            return $stmt->execute([
                $nombre_medico,
                $id_especialidad,
                $telefono
            ]);
        } catch (PDOException $e) {
            throw new Exception("Error al crear médico: " . $e->getMessage());
        }
    }

    // ==============================
    // OBTENER TODOS LOS MÉDICOS (READ)
    // ==============================
    public function obtenerTodos(){
        try {
            $sql = "
            SELECT 
                m.*,
                e.nombre_especialidad
            FROM medicos m
            LEFT JOIN especialidades e ON m.id_especialidad = e.id_especialidad
            ORDER BY m.nombre_medico ASC
            ";

            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener médicos: " . $e->getMessage());
        }
    }

    // ==============================
    // OBTENER MÉDICO POR ID (READ)
    // ==============================
    public function obtenerPorId($id){
        try {
            $sql = "
            SELECT 
                m.*,
                e.nombre_especialidad
            FROM medicos m
            LEFT JOIN especialidades e ON m.id_especialidad = e.id_especialidad
            WHERE m.id_medico = ?
            ";

            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$id]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener médico: " . $e->getMessage());
        }
    }

    // ==============================
    // OBTENER MÉDICOS POR ESPECIALIDAD
    // ==============================
    public function obtenerPorEspecialidad($id_especialidad){
        try {
            $sql = "
            SELECT 
                m.*,
                e.nombre_especialidad
            FROM medicos m
            LEFT JOIN especialidades e ON m.id_especialidad = e.id_especialidad
            WHERE m.id_especialidad = ?
            ORDER BY m.nombre_medico ASC
            ";

            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$id_especialidad]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener médicos: " . $e->getMessage());
        }
    }

    // ==============================
    // ACTUALIZAR MÉDICO (UPDATE)
    // ==============================
    public function actualizar($id, $nombre_medico, $id_especialidad, $telefono = null){
        try {
            $sql = "
            UPDATE medicos
            SET nombre_medico = ?,
                id_especialidad = ?,
                telefono = ?
            WHERE id_medico = ?
            ";

            $stmt = $this->conexion->prepare($sql);

            return $stmt->execute([
                $nombre_medico,
                $id_especialidad,
                $telefono,
                $id
            ]);
        } catch (PDOException $e) {
            throw new Exception("Error al actualizar médico: " . $e->getMessage());
        }
    }

    // ==============================
    // ELIMINAR MÉDICO (DELETE)
    // ==============================
    public function eliminar($id){
        try {
            $sql = "
            DELETE FROM medicos
            WHERE id_medico = ?
            ";

            $stmt = $this->conexion->prepare($sql);

            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            throw new Exception("Error al eliminar médico: " . $e->getMessage());
        }
    }

    // ==============================
    // BUSCAR MÉDICOS POR NOMBRE
    // ==============================
    public function buscarPorNombre($nombre){
        try {
            $sql = "
            SELECT 
                m.*,
                e.nombre_especialidad
            FROM medicos m
            LEFT JOIN especialidades e ON m.id_especialidad = e.id_especialidad
            WHERE m.nombre_medico ILIKE ?
            ORDER BY m.nombre_medico ASC
            ";

            $stmt = $this->conexion->prepare($sql);
            $stmt->execute(['%' . $nombre . '%']);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al buscar médicos: " . $e->getMessage());
        }
    }

    // ==============================
    // CONTAR MÉDICOS
    // ==============================
    public function contar(){
        try {
            $sql = "SELECT COUNT(*) as total FROM medicos";

            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();

            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado['total'];
        } catch (PDOException $e) {
            throw new Exception("Error al contar médicos: " . $e->getMessage());
        }
    }

    // ==============================
    // OBTENER CALIFICACIÓN PROMEDIO
    // ==============================
    public function obtenerCalificacionPromedio($id_medico){
        try {
            $sql = "
            SELECT AVG(cal.puntuacion) as promedio
            FROM calificaciones cal
            LEFT JOIN consultas c ON cal.id_consulta = c.id_consulta
            WHERE c.id_medico = ?
            ";

            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$id_medico]);

            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado['promedio'] ? round($resultado['promedio'], 2) : 0;
        } catch (PDOException $e) {
            throw new Exception("Error al obtener calificación: " . $e->getMessage());
        }
    }
}

?>
