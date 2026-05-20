<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../../config/conexion.php';
require_once __DIR__ . '/../models/Paciente.php';

$pacienteModel = new Paciente($conexion);

if(isset($_POST['accion'])){
    
    if($_POST['accion'] == 'crear'){
        try {
            $campos_requeridos = ['nombre', 'apellido', 'numero_identificacion', 'telefono'];
            $campos_vacios = [];
            
            foreach($campos_requeridos as $campo){
                if(empty($_POST[$campo])){
                    $campos_vacios[] = $campo;
                }
            }
            
            if(!empty($campos_vacios)){
                throw new Exception("Los siguientes campos son obligatorios: " . implode(", ", $campos_vacios));
            }

            if(!empty($_POST['correo']) && !filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL)){
                throw new Exception("El correo no es válido");
            }

            $paciente_existe = $pacienteModel->buscarPorIdentificacion($_POST['numero_identificacion']);
            if($paciente_existe){
                throw new Exception("El número de identificación ya está registrado");
            }

            $resultado = $pacienteModel->crear(
                htmlspecialchars($_POST['nombre']),
                htmlspecialchars($_POST['apellido']),
                !empty($_POST['correo']) ? htmlspecialchars($_POST['correo']) : null,
                htmlspecialchars($_POST['telefono']),
                !empty($_POST['fecha_nacimiento']) ? $_POST['fecha_nacimiento'] : null,
                !empty($_POST['genero']) ? $_POST['genero'] : null,
                !empty($_POST['direccion']) ? htmlspecialchars($_POST['direccion']) : null,
                htmlspecialchars($_POST['numero_identificacion'])
            );

            if($resultado){
                $_SESSION['success'] = "Paciente creado exitosamente";
                header("Location: ../views/pacientes/index.php");
                exit();
            }

        } catch(Exception $e){
            $_SESSION['error'] = $e->getMessage();
            header("Location: ../views/pacientes/create.php");
            exit();
        }
    }
    if($_POST['accion'] == 'actualizar'){
        try {
            $campos_requeridos = ['id_paciente', 'nombre', 'apellido', 'numero_identificacion', 'telefono'];
            $campos_vacios = [];
            
            foreach($campos_requeridos as $campo){
                if(empty($_POST[$campo])){
                    $campos_vacios[] = $campo;
                }
            }
            
            if(!empty($campos_vacios)){
                throw new Exception("Los siguientes campos son obligatorios: " . implode(", ", $campos_vacios));
            }

            if(!empty($_POST['correo']) && !filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL)){
                throw new Exception("El correo no es válido");
            }

            $resultado = $pacienteModel->actualizar(
                $_POST['id_paciente'],
                htmlspecialchars($_POST['nombre']),
                htmlspecialchars($_POST['apellido']),
                !empty($_POST['correo']) ? htmlspecialchars($_POST['correo']) : null,
                htmlspecialchars($_POST['telefono']),
                !empty($_POST['fecha_nacimiento']) ? $_POST['fecha_nacimiento'] : null,
                !empty($_POST['genero']) ? $_POST['genero'] : null,
                !empty($_POST['direccion']) ? htmlspecialchars($_POST['direccion']) : null
            );

            if($resultado){
                $_SESSION['success'] = "Paciente actualizado exitosamente";
                header("Location: ../views/pacientes/index.php");
                exit();
            }

        } catch(Exception $e){
            $_SESSION['error'] = $e->getMessage();
            header("Location: ../views/pacientes/edit.php?id=" . $_POST['id_paciente']);
            exit();
        }
    }
    if($_POST['accion'] == 'eliminar'){
        try {
            if(empty($_POST['id_paciente'])){
                throw new Exception("ID de paciente no especificado");
            }

            $resultado = $pacienteModel->eliminar($_POST['id_paciente']);

            if($resultado){
                $_SESSION['success'] = "Paciente eliminado exitosamente";
                header("Location: ../views/pacientes/index.php");
                exit();
            }

        } catch(Exception $e){
            $_SESSION['error'] = $e->getMessage();
            header("Location: ../views/pacientes/index.php");
            exit();
        }
    }
}
if(isset($_GET['accion'])){
    
    if($_GET['accion'] == 'listar'){
        try {
            $pacientes = $pacienteModel->obtenerTodos();
            
            if(!empty($_GET['ajax'])){
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'data' => $pacientes]);
                exit();
            } else {
                $_SESSION['pacientes'] = $pacientes;
            }
        } catch(Exception $e){
            if(!empty($_GET['ajax'])){
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => $e->getMessage()]);
                exit();
            } else {
                $_SESSION['error'] = $e->getMessage();
            }
        }
    }
        if($_GET['accion'] == 'obtener' && !empty($_GET['id'])){
            try {
                $paciente = $pacienteModel->obtenerPorId($_GET['id']);
                
                if(!$paciente){
                    throw new Exception("Paciente no encontrado");
                }
                if(!empty($_GET['ajax'])){
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'data' => $paciente]);
                    exit();
                } else {
                    $_SESSION['paciente'] = $paciente;
                }
            } catch(Exception $e){
                if(!empty($_GET['ajax'])){
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
                    exit();
                } else {
                    $_SESSION['error'] = $e->getMessage();
                }
            }
        }
    }
?>