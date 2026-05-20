<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require_once __DIR__ . '/../../config/conexion.php';
require_once __DIR__ . '/../models/Especialidad.php';
require_once __DIR__ . '/../helpers/HelperValidacion.php';

$especialidadModel = new Especialidad($conexion);

if(isset($_POST['accion'])){
 
    if($_POST['accion'] == 'crear'){
        try {
            validarNoVacio($_POST['nombre_especialidad'] ?? '', 'Nombre de especialidad');

            $resultado = $especialidadModel->crear(
                sanitizarString($_POST['nombre_especialidad']),
                !empty($_POST['descripcion']) ? sanitizarString($_POST['descripcion']) : null
            );
            if($resultado){
                $_SESSION['success'] = "Especialidad creada exitosamente";
                header("Location: ../views/especialidades/index.php");
                exit();
            }
        } catch(Exception $e){
            $_SESSION['error'] = $e->getMessage();
            header("Location: ../views/especialidades/create.php");
            exit();
        }
    }
    if($_POST['accion'] == 'actualizar'){
        try {
            validarNoVacio($_POST['id_especialidad'] ?? '', 'ID de especialidad');
            validarNoVacio($_POST['nombre_especialidad'] ?? '', 'Nombre de especialidad');

            $resultado = $especialidadModel->actualizar(
                $_POST['id_especialidad'],
                sanitizarString($_POST['nombre_especialidad']),
                !empty($_POST['descripcion']) ? sanitizarString($_POST['descripcion']) : null
            );

            if($resultado){
                $_SESSION['success'] = "Especialidad actualizada exitosamente";
                header("Location: ../views/especialidades/index.php");
                exit();
            }

        } catch(Exception $e){
            $_SESSION['error'] = $e->getMessage();
            header("Location: ../views/especialidades/edit.php?id=" . $_POST['id_especialidad']);
            exit();
        }
    }
    if($_POST['accion'] == 'eliminar'){
        try {
            validarNoVacio($_POST['id_especialidad'] ?? '', 'ID de especialidad');

            $resultado = $especialidadModel->eliminar($_POST['id_especialidad']);

            if($resultado){
                $_SESSION['success'] = "Especialidad eliminada exitosamente";
                header("Location: ../views/especialidades/index.php");
                exit();
            }

        } catch(Exception $e){
            $_SESSION['error'] = $e->getMessage();
            header("Location: ../views/especialidades/index.php");
            exit();
        }
    }
}
if(isset($_GET['accion'])){
    
    if($_GET['accion'] == 'listar'){
        try {
            $especialidades = $especialidadModel->obtenerTodas();
            
            if(!empty($_GET['ajax'])){
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'data' => $especialidades]);
            } else {
                $_SESSION['especialidades'] = $especialidades;
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
            $especialidad = $especialidadModel->obtenerPorId($_GET['id']);
            
            if(!$especialidad){
                throw new Exception("Especialidad no encontrada");
            }

            if(!empty($_GET['ajax'])){
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'data' => $especialidad]);
            } else {
                $_SESSION['especialidad'] = $especialidad;
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

        if($_GET['accion'] == 'con_medicos'){
            try {
                $especialidades = $especialidadModel->obtenerMedicosPorEspecialidad();
                
                if(!empty($_GET['ajax'])){
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'data' => $especialidades]);
                } else {
                    $_SESSION['especialidades'] = $especialidades;
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
