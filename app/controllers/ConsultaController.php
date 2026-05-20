<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

require_once __DIR__ . '/../../config/conexion.php';
require_once __DIR__ . '/../models/Consulta.php';
require_once __DIR__ . '/../models/Paciente.php';

$consultaModel = new Consulta($conexion);
$pacienteModel = new Paciente($conexion);

if(isset($_POST['accion'])){

    if($_POST['accion'] == 'crear'){
        try {
            $campos_requeridos = ['id_paciente', 'id_medico', 'diagnostico'];
            $campos_vacios = [];
            
            foreach($campos_requeridos as $campo){
                if(empty($_POST[$campo])){
                    $campos_vacios[] = $campo;
                }
            }
            if(!empty($campos_vacios)){
                throw new Exception("Los siguientes campos son obligatorios: " . implode(", ", $campos_vacios));
            }
            $paciente = $pacienteModel->obtenerPorId($_POST['id_paciente']);
            if(!$paciente){
                throw new Exception("El paciente especificado no existe");
            }
            $resultado = $consultaModel->crear(
                $_POST['id_paciente'],
                $_POST['id_medico'],
                htmlspecialchars($_POST['diagnostico']),
                !empty($_POST['tratamiento']) ? htmlspecialchars($_POST['tratamiento']) : null,
                !empty($_POST['observaciones']) ? htmlspecialchars($_POST['observaciones']) : null,
                !empty($_POST['presion_arterial']) ? htmlspecialchars($_POST['presion_arterial']) : null,
                !empty($_POST['temperatura']) ? $_POST['temperatura'] : null,
                !empty($_POST['peso']) ? $_POST['peso'] : null,
                !empty($_POST['altura']) ? $_POST['altura'] : null
            );
            if($resultado){
                $_SESSION['success'] = "Consulta registrada exitosamente";
                header("Location: ../views/consultas/index.php");
                exit();
            }
        } catch(Exception $e){
            $_SESSION['error'] = $e->getMessage();
            header("Location: ../views/consultas/create.php");
            exit();
        }
    }
    if($_POST['accion'] == 'actualizar'){
        try {
            $campos_requeridos = ['id_consulta', 'id_paciente', 'id_medico', 'diagnostico'];
            $campos_vacios = [];
            
            foreach($campos_requeridos as $campo){
                if(empty($_POST[$campo])){
                    $campos_vacios[] = $campo;
                }
            }
            if(!empty($campos_vacios)){
                throw new Exception("Los siguientes campos son obligatorios: " . implode(", ", $campos_vacios));
            }
            $resultado = $consultaModel->actualizar(
                $_POST['id_consulta'],
                $_POST['id_paciente'],
                $_POST['id_medico'],
                htmlspecialchars($_POST['diagnostico']),
                !empty($_POST['tratamiento']) ? htmlspecialchars($_POST['tratamiento']) : null,
                !empty($_POST['observaciones']) ? htmlspecialchars($_POST['observaciones']) : null,
                !empty($_POST['presion_arterial']) ? htmlspecialchars($_POST['presion_arterial']) : null,
                !empty($_POST['temperatura']) ? $_POST['temperatura'] : null,
                !empty($_POST['peso']) ? $_POST['peso'] : null,
                !empty($_POST['altura']) ? $_POST['altura'] : null
            );
            if($resultado){
                $_SESSION['success'] = "Consulta actualizada exitosamente";
                header("Location: ../views/consultas/index.php");
                exit();
            }
        } catch(Exception $e){
            $_SESSION['error'] = $e->getMessage();
            header("Location: ../views/consultas/edit.php?id=" . $_POST['id_consulta']);
            exit();
        }
    }
    if($_POST['accion'] == 'eliminar'){
        try {
            if(empty($_POST['id_consulta'])){
                throw new Exception("ID de consulta no especificado");
            }
            $resultado = $consultaModel->eliminar($_POST['id_consulta']);

            if($resultado){
                $_SESSION['success'] = "Consulta eliminada exitosamente";
                header("Location: ../views/consultas/index.php");
                exit();
            }
        } catch(Exception $e){
            $_SESSION['error'] = $e->getMessage();
            header("Location: ../views/consultas/index.php");
            exit();
        }
    }
}
if(isset($_GET['accion'])){
    
    if($_GET['accion'] == 'listar'){
        try {
            $consultas = $consultaModel->obtenerTodas();
            
            if(!empty($_GET['ajax'])){
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'data' => $consultas]);
            } else {
                $_SESSION['consultas'] = $consultas;
            }
        } catch(Exception $e){
            if(!empty($_GET['ajax'])){
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => $e->getMessage()]);
            } else {
                $_SESSION['error'] = $e->getMessage();
            }
        }
    }
    if($_GET['accion'] == 'obtener' && !empty($_GET['id'])){
        try {
            $consulta = $consultaModel->obtenerPorId($_GET['id']);
            
            if(!$consulta){
                throw new Exception("Consulta no encontrada");
            }

            if(!empty($_GET['ajax'])){
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'data' => $consulta]);
            } else {
                $_SESSION['consulta'] = $consulta;
            }
        } catch(Exception $e){
            if(!empty($_GET['ajax'])){
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => $e->getMessage()]);
            } else {
                $_SESSION['error'] = $e->getMessage();
            }
        }
    }
        if($_GET['accion'] == 'por_paciente' && !empty($_GET['id_paciente'])){
            try {
                $consultas = $consultaModel->obtenerPorPaciente($_GET['id_paciente']);
                
                if(!empty($_GET['ajax'])){
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'data' => $consultas]);
                } else {
                    $_SESSION['consultas'] = $consultas;
                }
            } catch(Exception $e){
                if(!empty($_GET['ajax'])){
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
                } else {
                    $_SESSION['error'] = $e->getMessage();
                }
            }
        }
    }
?>
