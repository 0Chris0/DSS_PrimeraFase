<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../config/conexion.php';
require_once __DIR__ . '/../models/Cita.php';
require_once __DIR__ . '/../helpers/HelperValidacion.php';

class CitasController {
    // 1. Declaración explícita de propiedades para evitar el error de "dynamic property"
    private $pdo;
    private $citaModel;

    public function __construct($conexion = null) {
        if ($conexion) {
            $this->pdo = $conexion;
        } else {
            $host = "localhost";
            $port = "3306";
            $db = "clinica";
            $user = "root";
            $pass = "";

            try {
                $this->pdo = new PDO(
                    "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4",
                    $user,
                    $pass,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ]
                );
                
                // Ahora esto no dará error porque $citaModel está declarada arriba
                $this->citaModel = new Cita($this->pdo);

            } catch (PDOException $e) {
                die("Error de conexión: " . $e->getMessage());
            }
        }
    }

    public function listarCitas() {
        try {
            $sql = "SELECT 
                        c.id_cita, 
                        c.id_paciente, 
                        c.id_medico, 
                        c.fecha_cita, 
                        c.hora_cita, 
                        c.estado, 
                        p.nombre_paciente, 
                        p.apellido_paciente,
                        m.nombre_medico, 
                        e.nombre_especialidad 
                    FROM citas c
                    LEFT JOIN pacientes p ON c.id_paciente = p.id_paciente
                    LEFT JOIN medicos m ON c.id_medico = m.id_medico
                    LEFT JOIN especialidades e ON m.id_especialidad = e.id_especialidad
                    ORDER BY c.fecha_cita DESC";
                    
            return $this->pdo->query($sql)->fetchAll();
        } catch (PDOException $e) {
            throw new Exception("Error al listar citas: " . $e->getMessage());
        }
    }

    public function obtenerMedicos() {
        try {
            $sql = "SELECT m.id_medico, m.nombre_medico, e.nombre_especialidad 
                    FROM medicos m
                    LEFT JOIN especialidades e ON m.id_especialidad = e.id_especialidad
                    ORDER BY m.nombre_medico ASC";
            return $this->pdo->query($sql)->fetchAll();
        } catch (PDOException $e) {
            throw new Exception("Error al obtener médicos: " . $e->getMessage());
        }
    }

    public function obtenerPacientes() {
        try {
            $sql = "SELECT id_paciente, nombre_paciente, apellido_paciente, numero_identificacion
                    FROM pacientes
                    ORDER BY nombre_paciente ASC";
            return $this->pdo->query($sql)->fetchAll();
        } catch (PDOException $e) {
            throw new Exception("Error al obtener pacientes: " . $e->getMessage());
        }
    }

    public function guardarCita($id_paciente, $id_medico, $fecha_cita, $hora_cita = null, $estado = 'Programada') {
        try {
            validarNoVacio($id_paciente, 'Paciente');
            validarNoVacio($id_medico, 'Médico');
            validarNoVacio($fecha_cita, 'Fecha de cita');

            $sql = "INSERT INTO citas (id_paciente, id_medico, fecha_cita, hora_cita, estado) 
                    VALUES (:id_paciente, :id_medico, :fecha_cita, :hora_cita, :estado)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                ':id_paciente' => $id_paciente,
                ':id_medico'   => $id_medico,
                ':fecha_cita'  => $fecha_cita,
                ':hora_cita'   => $hora_cita,
                ':estado'      => $estado
            ]);
        } catch (Exception $e) {
            throw new Exception("Error al guardar cita: " . $e->getMessage());
        }
    }

    public function obtenerPorId($id) {
        try {
            $sql = "SELECT c.*, p.nombre_paciente, p.apellido_paciente,
                           m.nombre_medico, e.nombre_especialidad
                    FROM citas c
                    LEFT JOIN pacientes p ON c.id_paciente = p.id_paciente
                    LEFT JOIN medicos m ON c.id_medico = m.id_medico
                    LEFT JOIN especialidades e ON m.id_especialidad = e.id_especialidad
                    WHERE c.id_cita = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            throw new Exception("Error al obtener cita: " . $e->getMessage());
        }
    }

    public function actualizarCita($id_cita, $id_medico, $fecha_cita, $id_paciente = null, $hora_cita = null, $estado = null) {
        try {
            validarNoVacio($id_cita, 'ID de cita');
            validarNoVacio($id_medico, 'Médico');
            validarNoVacio($fecha_cita, 'Fecha');

            $sql = "UPDATE citas 
                    SET id_medico = :id_medico, 
                        fecha_cita = :fecha_cita,
                        id_paciente = :id_paciente,
                        hora_cita = :hora_cita,
                        estado = :estado
                    WHERE id_cita = :id_cita";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                ':id_medico'   => $id_medico,
                ':fecha_cita'  => $fecha_cita,
                ':id_paciente' => $id_paciente,
                ':hora_cita'   => $hora_cita,
                ':estado'      => $estado ?? 'Programada',
                ':id_cita'     => $id_cita
            ]);
        } catch (Exception $e) {
            throw new Exception("Error al actualizar cita: " . $e->getMessage());
        }
    }

    public function eliminarCita($id) {
        try {
            validarNoVacio($id, 'ID de cita');
            $sql = "DELETE FROM citas WHERE id_cita = :id";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (Exception $e) {
            throw new Exception("Error al eliminar cita: " . $e->getMessage());
        }
    }

    // --- Métodos de resumen y estados omitidos por brevedad, mantienen la misma lógica ---
    // (Puedes dejar los tuyos tal cual, ya que funcionan correctamente para MySQL)
    public function obtenerTotalCitasHoy() {
        try {
            return $this->pdo->query("SELECT COUNT(*) FROM citas WHERE fecha_cita = CURDATE()")->fetchColumn();
        } catch (Exception $e) {
            return 0;
        }
    }
}