<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require_once __DIR__ . '/../../config/conexion.php';
require_once __DIR__ . '/../models/Calificacion.php';

$calificacionModel = new Calificacion($conexion);
if(isset($_POST['accion'])){
    if($_POST['accion'] == 'crear'){
        try {
            $campos_requeridos = ['id_consulta', 'id_paciente', 'puntuacion'];
            $campos_vacios = [];
            foreach($campos_requeridos as $campo){
                if(empty($_POST[$campo])){
                    $campos_vacios[] = $campo;
                }
            }
            if(!empty($campos_vacios)){
                throw new Exception("Los siguientes campos son obligatorios: " . implode(", ", $campos_vacios));
            }
            $puntuacion = intval($_POST['puntuacion']);
            if($puntuacion < 1 || $puntuacion > 5){
                throw new Exception("La puntuación debe estar entre 1 y 5");
            }
            $resultado = $calificacionModel->crear(
                $_POST['id_consulta'],
                $_POST['id_paciente'],
                $puntuacion,
                !empty($_POST['comentario']) ? htmlspecialchars($_POST['comentario']) : null
            );
            if($resultado){
                $_SESSION['success'] = "Calificación registrada exitosamente";
                header("Location: ../views/calificaciones/index.php");
                exit();
            }
        } catch(Exception $e){
            $_SESSION['error'] = $e->getMessage();
            header("Location: ../views/calificaciones/create.php");
            exit();
        }
    }
    if($_POST['accion'] == 'actualizar'){
        try {
            $campos_requeridos = ['id_calificacion', 'puntuacion'];
            $campos_vacios = [];
            foreach($campos_requeridos as $campo){
                if(empty($_POST[$campo])){
                    $campos_vacios[] = $campo;
                }
            }
            if(!empty($campos_vacios)){
                throw new Exception("Los siguientes campos son obligatorios: " . implode(", ", $campos_vacios));
            }
            $puntuacion = intval($_POST['puntuacion']);
            if($puntuacion < 1 || $puntuacion > 5){
                throw new Exception("La puntuación debe estar entre 1 y 5");
            }
            $resultado = $calificacionModel->actualizar(
                $_POST['id_calificacion'],
                $puntuacion,
                !empty($_POST['comentario']) ? htmlspecialchars($_POST['comentario']) : null
            );
            if($resultado){
                $_SESSION['success'] = "Calificación actualizada exitosamente";
                header("Location: ../views/calificaciones/index.php");
                exit();
            }
        } catch(Exception $e){
            $_SESSION['error'] = $e->getMessage();
            header("Location: ../views/calificaciones/edit.php?id=" . $_POST['id_calificacion']);
            exit();
        }
    }
    if($_POST['accion'] == 'eliminar'){
        try {
            if(empty($_POST['id_calificacion'])){
                throw new Exception("ID de calificación no especificado");
            }
            $resultado = $calificacionModel->eliminar($_POST['id_calificacion']);
            if($resultado){
                $_SESSION['success'] = "Calificación eliminada exitosamente";
                header("Location: ../views/calificaciones/index.php");
                exit();
            }
        } catch(Exception $e){
            $_SESSION['error'] = $e->getMessage();
            header("Location: ../views/calificaciones/index.php");
            exit();
        }
    }
}
if(isset($_GET['accion'])){

    if($_GET['accion'] == 'listar'){
        try {
            $calificaciones = $calificacionModel->obtenerTodas();
            
            if(!empty($_GET['ajax'])){
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'data' => $calificaciones]);
            } else {
                $_SESSION['calificaciones'] = $calificaciones;
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
            $calificacion = $calificacionModel->obtenerPorId($_GET['id']);
            if(!$calificacion){
                throw new Exception("Calificación no encontrada");
            }
            if(!empty($_GET['ajax'])){
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'data' => $calificacion]);
            } else {
                $_SESSION['calificacion'] = $calificacion;
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
        if($_GET['accion'] == 'promedio_medico' && !empty($_GET['id_medico'])){
            try {
                $promedio = $calificacionModel->obtenerPromedioMedico($_GET['id_medico']);
                
                if(!empty($_GET['ajax'])){
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'data' => ['promedio' => $promedio]]);
                } else {
                    $_SESSION['promedio'] = $promedio;
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
