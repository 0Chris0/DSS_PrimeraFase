<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require_once __DIR__ . '/../../config/conexion.php';
require_once __DIR__ . '/../models/Medico.php';
require_once __DIR__ . '/../models/Especialidad.php';
require_once __DIR__ . '/../helpers/HelperValidacion.php';

$medicoModel = new Medico($conexion);
$especialidadModel = new Especialidad($conexion);

if(isset($_POST['accion'])){

    if($_POST['accion'] == 'crear'){
        try {
            validarNoVacio($_POST['nombre_medico'] ?? '', 'Nombre del médico');
            validarNoVacio($_POST['id_especialidad'] ?? '', 'Especialidad');

            $resultado = $medicoModel->crear(
                sanitizarString($_POST['nombre_medico']),
                $_POST['id_especialidad'],
                !empty($_POST['telefono']) ? sanitizarString($_POST['telefono']) : null
            );

            if($resultado){
                $_SESSION['success'] = "Médico creado exitosamente";
                header("Location: ../views/medicos/index.php");
                exit();
            }

        } catch(Exception $e){
            $_SESSION['error'] = $e->getMessage();
            header("Location: ../views/medicos/create.php");
            exit();
        }
    }

    if($_POST['accion'] == 'actualizar'){
        try {
            validarNoVacio($_POST['id_medico'] ?? '', 'ID del médico');
            validarNoVacio($_POST['nombre_medico'] ?? '', 'Nombre del médico');
            validarNoVacio($_POST['id_especialidad'] ?? '', 'Especialidad');

            $resultado = $medicoModel->actualizar(
                $_POST['id_medico'],
                sanitizarString($_POST['nombre_medico']),
                $_POST['id_especialidad'],
                !empty($_POST['telefono']) ? sanitizarString($_POST['telefono']) : null
            );

            if($resultado){
                $_SESSION['success'] = "Médico actualizado exitosamente";
                header("Location: ../views/medicos/index.php");
                exit();
            }

        } catch(Exception $e){
            $_SESSION['error'] = $e->getMessage();
            header("Location: ../views/medicos/edit.php?id=" . $_POST['id_medico']);
            exit();
        }
    }

    if($_POST['accion'] == 'eliminar'){
        try {
            validarNoVacio($_POST['id_medico'] ?? '', 'ID del médico');

            $resultado = $medicoModel->eliminar($_POST['id_medico']);

            if($resultado){
                $_SESSION['success'] = "Médico eliminado exitosamente";
                header("Location: ../views/medicos/index.php");
                exit();
            }

        } catch(Exception $e){
            $_SESSION['error'] = $e->getMessage();
            header("Location: ../views/medicos/index.php");
            exit();
        }
    }
}
if(isset($_GET['accion'])){
    
    if($_GET['accion'] == 'listar'){
        try {
            $medicos = $medicoModel->obtenerTodos();
            
            if(!empty($_GET['ajax'])){
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'data' => $medicos]);
            } else {
                $_SESSION['medicos'] = $medicos;
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
            $medico = $medicoModel->obtenerPorId($_GET['id']);
            
            if(!$medico){
                throw new Exception("Médico no encontrado");
            }

            if(!empty($_GET['ajax'])){
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'data' => $medico]);
            } else {
                $_SESSION['medico'] = $medico;
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

    if($_GET['accion'] == 'por_especialidad' && !empty($_GET['id_especialidad'])){
        try {
            $medicos = $medicoModel->obtenerPorEspecialidad($_GET['id_especialidad']);
            
            if(!empty($_GET['ajax'])){
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'data' => $medicos]);
            } else {
                $_SESSION['medicos'] = $medicos;
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
        if($_GET['accion'] == 'calificacion' && !empty($_GET['id'])){
            try {
                $calificacion = $medicoModel->obtenerCalificacionPromedio($_GET['id']);
                
                if(!empty($_GET['ajax'])){
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'data' => ['calificacion' => $calificacion]]);
                }
            } catch(Exception $e){
                if(!empty($_GET['ajax'])){
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
                }
            }
        }
    }
?>
