<?php

class Consulta {

    // VARIABLE DE CONEXIÓN PDO
    // ==============================
    private $conexion;

    // ==============================
    // CONSTRUCTOR
    // ==============================
    public function __construct($conexion){
        $this->conexion = $conexion;
    }

    // ==============================
    // CREAR CONSULTA (CREATE)
    // ==============================
    public function crear($id_paciente, $id_medico, $diagnostico, $tratamiento, $observaciones, $presion_arterial, $temperatura, $peso, $altura){
        try {
            $sql = "
            INSERT INTO consultas (
                id_paciente,
                id_medico,
                diagnóstico,
                tratamiento,
                observaciones,
                presión_arterial,
                temperatura,
                peso,
                altura
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ";

            $stmt = $this->conexion->prepare($sql);

            return $stmt->execute([
                $id_paciente,
                $id_medico,
                $diagnostico,
                $tratamiento,
                $observaciones,
                $presion_arterial,
                $temperatura,
                $peso,
                $altura
            ]);
        } catch (PDOException $e) {
            throw new Exception("Error al crear consulta: " . $e->getMessage());
        }
    }

    // ==============================
    // OBTENER TODAS LAS CONSULTAS (READ)
    // ==============================
    public function obtenerTodas(){
        try {
            $sql = "
            SELECT 
                c.*,
                p.nombre_paciente,
                p.apellido_paciente,
                m.nombre_medico,
                e.nombre_especialidad
            FROM consultas c
            LEFT JOIN pacientes p ON c.id_paciente = p.id_paciente
            LEFT JOIN medicos m ON c.id_medico = m.id_medico
            LEFT JOIN especialidades e ON m.id_especialidad = e.id_especialidad
            ORDER BY c.fecha_consulta DESC
            ";

            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener consultas: " . $e->getMessage());
        }
    }

    // ==============================
    // OBTENER CONSULTA POR ID (READ)
    // ==============================
    public function obtenerPorId($id){
        try {
            $sql = "
            SELECT 
                c.*,
                p.nombre_paciente,
                p.apellido_paciente,
                m.nombre_medico,
                e.nombre_especialidad
            FROM consultas c
            LEFT JOIN pacientes p ON c.id_paciente = p.id_paciente
            LEFT JOIN medicos m ON c.id_medico = m.id_medico
            LEFT JOIN especialidades e ON m.id_especialidad = e.id_especialidad
            WHERE c.id_consulta = ?
            ";

            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$id]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener consulta: " . $e->getMessage());
        }
    }

    // ==============================
    // OBTENER CONSULTAS POR PACIENTE
    // ==============================
    public function obtenerPorPaciente($id_paciente){
        try {
            $sql = "
            SELECT 
                c.*,
                p.nombre_paciente,
                p.apellido_paciente,
                m.nombre_medico,
                e.nombre_especialidad
            FROM consultas c
            LEFT JOIN pacientes p ON c.id_paciente = p.id_paciente
            LEFT JOIN medicos m ON c.id_medico = m.id_medico
            LEFT JOIN especialidades e ON m.id_especialidad = e.id_especialidad
            WHERE c.id_paciente = ?
            ORDER BY c.fecha_consulta DESC
            ";

            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$id_paciente]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener consultas del paciente: " . $e->getMessage());
        }
    }

    // ==============================
    // OBTENER CONSULTAS POR MÉDICO
    // ==============================
    public function obtenerPorMedico($id_medico){
        try {
            $sql = "
            SELECT 
                c.*,
                p.nombre_paciente,
                p.apellido_paciente,
                m.nombre_medico,
                e.nombre_especialidad
            FROM consultas c
            LEFT JOIN pacientes p ON c.id_paciente = p.id_paciente
            LEFT JOIN medicos m ON c.id_medico = m.id_medico
            LEFT JOIN especialidades e ON m.id_especialidad = e.id_especialidad
            WHERE c.id_medico = ?
            ORDER BY c.fecha_consulta DESC
            ";

            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$id_medico]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener consultas del médico: " . $e->getMessage());
        }
    }

    // ==============================
    // ACTUALIZAR CONSULTA (UPDATE)
    // ==============================
    public function actualizar($id, $id_paciente, $id_medico, $diagnostico, $tratamiento, $observaciones, $presion_arterial, $temperatura, $peso, $altura){
        try {
            $sql = "
            UPDATE consultas
            SET id_paciente = ?,
                id_medico = ?,
                diagnóstico = ?,
                tratamiento = ?,
                observaciones = ?,
                presión_arterial = ?,
                temperatura = ?,
                peso = ?,
                altura = ?
            WHERE id_consulta = ?
            ";

            $stmt = $this->conexion->prepare($sql);

            return $stmt->execute([
                $id_paciente,
                $id_medico,
                $diagnostico,
                $tratamiento,
                $observaciones,
                $presion_arterial,
                $temperatura,
                $peso,
                $altura,
                $id
            ]);
        } catch (PDOException $e) {
            throw new Exception("Error al actualizar consulta: " . $e->getMessage());
        }
    }

    // ==============================
    // ELIMINAR CONSULTA (DELETE)
    // ==============================
    public function eliminar($id){
        try {
            $sql = "
            DELETE FROM consultas
            WHERE id_consulta = ?
            ";

            $stmt = $this->conexion->prepare($sql);

            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            throw new Exception("Error al eliminar consulta: " . $e->getMessage());
        }
    }

    // ==============================
    // CONTAR CONSULTAS
    // ==============================
    public function contar(){
        try {
            $sql = "SELECT COUNT(*) as total FROM consultas";

            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();

            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado['total'];
        } catch (PDOException $e) {
            throw new Exception("Error al contar consultas: " . $e->getMessage());
        }
    }
}

?>
