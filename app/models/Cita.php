<?php

class Cita {

    private $conexion;

    public function __construct($conexion){
        $this->conexion = $conexion;
    }

    // ==============================
    // CREAR CITA (CREATE)
    // ==============================
    public function crear($id_paciente, $id_medico, $fecha_cita, $hora_cita = null, $estado = 'Programada', $motivo_cita = null){
        try {
            $sql = "
            INSERT INTO citas (
                id_paciente,
                id_medico,
                fecha_cita,
                hora_cita,
                estado,
                motivo_cita
            )
            VALUES (?, ?, ?, ?, ?, ?)
            ";

            $stmt = $this->conexion->prepare($sql);

            return $stmt->execute([
                $id_paciente,
                $id_medico,
                $fecha_cita,
                $hora_cita,
                $estado,
                $motivo_cita
            ]);
        } catch (PDOException $e) {
            throw new Exception("Error al crear cita: " . $e->getMessage());
        }
    }

    // ==============================
    // OBTENER TODAS LAS CITAS (READ)
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
            FROM citas c
            LEFT JOIN pacientes p ON c.id_paciente = p.id_paciente
            LEFT JOIN medicos m ON c.id_medico = m.id_medico
            LEFT JOIN especialidades e ON m.id_especialidad = e.id_especialidad
            ORDER BY c.fecha_cita DESC
            ";

            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener citas: " . $e->getMessage());
        }
    }

    // ==============================
    // OBTENER CITA POR ID (READ)
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
            FROM citas c
            LEFT JOIN pacientes p ON c.id_paciente = p.id_paciente
            LEFT JOIN medicos m ON c.id_medico = m.id_medico
            LEFT JOIN especialidades e ON m.id_especialidad = e.id_especialidad
            WHERE c.id_cita = ?
            ";

            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$id]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener cita: " . $e->getMessage());
        }
    }

    // ==============================
    // OBTENER CITAS POR PACIENTE
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
            FROM citas c
            LEFT JOIN pacientes p ON c.id_paciente = p.id_paciente
            LEFT JOIN medicos m ON c.id_medico = m.id_medico
            LEFT JOIN especialidades e ON m.id_especialidad = e.id_especialidad
            WHERE c.id_paciente = ?
            ORDER BY c.fecha_cita DESC
            ";

            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$id_paciente]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener citas del paciente: " . $e->getMessage());
        }
    }

    // ==============================
    // OBTENER CITAS POR MÉDICO
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
            FROM citas c
            LEFT JOIN pacientes p ON c.id_paciente = p.id_paciente
            LEFT JOIN medicos m ON c.id_medico = m.id_medico
            LEFT JOIN especialidades e ON m.id_especialidad = e.id_especialidad
            WHERE c.id_medico = ?
            ORDER BY c.fecha_cita DESC
            ";

            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$id_medico]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener citas del médico: " . $e->getMessage());
        }
    }

    // ==============================
    // ACTUALIZAR CITA (UPDATE)
    // ==============================
    public function actualizar($id, $id_paciente, $id_medico, $fecha_cita, $hora_cita = null, $estado = null, $motivo_cita = null){
        try {
            $sql = "
            UPDATE citas
            SET id_paciente = ?,
                id_medico = ?,
                fecha_cita = ?,
                hora_cita = ?,
                estado = ?,
                motivo_cita = ?
            WHERE id_cita = ?
            ";

            $stmt = $this->conexion->prepare($sql);

            return $stmt->execute([
                $id_paciente,
                $id_medico,
                $fecha_cita,
                $hora_cita,
                $estado,
                $motivo_cita,
                $id
            ]);
        } catch (PDOException $e) {
            throw new Exception("Error al actualizar cita: " . $e->getMessage());
        }
    }

    // ==============================
    // ELIMINAR CITA (DELETE)
    // ==============================
    public function eliminar($id){
        try {
            $sql = "
            DELETE FROM citas
            WHERE id_cita = ?
            ";

            $stmt = $this->conexion->prepare($sql);

            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            throw new Exception("Error al eliminar cita: " . $e->getMessage());
        }
    }

    // ==============================
    // CAMBIAR ESTADO DE CITA
    // ==============================
    public function cambiarEstado($id, $estado){
        try {
            $estados_validos = ['Programada', 'Completada', 'Cancelada', 'Reprogramada'];
            if(!in_array($estado, $estados_validos)){
                throw new Exception("Estado inválido");
            }

            $sql = "
            UPDATE citas
            SET estado = ?
            WHERE id_cita = ?
            ";

            $stmt = $this->conexion->prepare($sql);

            return $stmt->execute([$estado, $id]);
        } catch (PDOException $e) {
            throw new Exception("Error al cambiar estado: " . $e->getMessage());
        }
    }

    // ==============================
    // OBTENER CITAS POR ESTADO
    // ==============================
    public function obtenerPorEstado($estado){
        try {
            $sql = "
            SELECT 
                c.*,
                p.nombre_paciente,
                p.apellido_paciente,
                m.nombre_medico,
                e.nombre_especialidad
            FROM citas c
            LEFT JOIN pacientes p ON c.id_paciente = p.id_paciente
            LEFT JOIN medicos m ON c.id_medico = m.id_medico
            LEFT JOIN especialidades e ON m.id_especialidad = e.id_especialidad
            WHERE c.estado = ?
            ORDER BY c.fecha_cita DESC
            ";

            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$estado]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener citas: " . $e->getMessage());
        }
    }

    // ==============================
    // CONTAR CITAS
    // ==============================
    public function contar(){
        try {
            $sql = "SELECT COUNT(*) as total FROM citas";

            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();

            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado['total'];
        } catch (PDOException $e) {
            throw new Exception("Error al contar citas: " . $e->getMessage());
        }
    }

    // ==============================
    // OBTENER CITAS PRÓXIMAS (PRÓXIMOS 7 DÍAS)
    // ==============================
    public function obtenerProximas(){
        try {
            $sql = "
            SELECT 
                c.*,
                p.nombre_paciente,
                p.apellido_paciente,
                m.nombre_medico,
                e.nombre_especialidad
            FROM citas c
            LEFT JOIN pacientes p ON c.id_paciente = p.id_paciente
            LEFT JOIN medicos m ON c.id_medico = m.id_medico
            LEFT JOIN especialidades e ON m.id_especialidad = e.id_especialidad
            WHERE c.fecha_cita >= CURRENT_DATE 
              AND c.fecha_cita <= CURRENT_DATE + INTERVAL '7 days'
              AND c.estado = 'Programada'
            ORDER BY c.fecha_cita ASC
            ";

            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener citas próximas: " . $e->getMessage());
        }
    }
}

?>
