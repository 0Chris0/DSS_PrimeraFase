<?php
session_start();
require_once __DIR__ . '/../../config/conexion.php';
require_once __DIR__ . '/../models/Usuario.php';

$usuarioModel = new Usuario($conexion);

// --- LÓGICA DE REGISTRO ---
if (isset($_POST['accion']) && $_POST['accion'] === 'registrar') {
    $correo = trim($_POST['correo']);
    $password = $_POST['password'];
    $confirmar = $_POST['confirmar_password'];

    if ($password !== $confirmar) {
        $_SESSION['error'] = "Las contraseñas no coinciden.";
        header("Location: ../views/auth/register.php");
        exit();
    }

    $hash = password_hash($password, PASSWORD_BCRYPT);

    try {
        $conexion->beginTransaction();

        // 1. Insertar en usuarios
        $sqlUsuario = "INSERT INTO usuarios (username, correo, password, rol) VALUES (?, ?, ?, ?)";
        $stmtU = $conexion->prepare($sqlUsuario);
        $stmtU->execute([$correo, $correo, $hash, 'paciente']);

        // 2. Insertar fila en pacientes
        $sqlPaciente = "INSERT INTO pacientes (correo_paciente, nombre_paciente) VALUES (?, ?)";
        $stmtP = $conexion->prepare($sqlPaciente);
        $stmtP->execute([$correo, 'Nuevo Usuario']);

        $conexion->commit();
        $_SESSION['success'] = "Cuenta creada correctamente.";
        header("Location: ../views/auth/login.php");
        exit();
    } catch (Exception $e) {
        $conexion->rollBack();
        $_SESSION['error'] = "Error al registrar: " . $e->getMessage();
        header("Location: ../views/auth/register.php");
        exit();
    }
} 

elseif (isset($_POST['accion']) && $_POST['accion'] === 'login') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['error'] = "Error de seguridad (CSRF).";
        header("Location: ../views/auth/login.php");
        exit();
    }

    $correo = trim($_POST['correo']);
    $password = $_POST['password'];

    $usuario = $usuarioModel->obtenerPorCorreo($correo);

    if ($usuario && password_verify($password, $usuario['password'])) {
        session_regenerate_id(true);
        $_SESSION['id_usuario'] = $usuario['id_usuario'];
        $_SESSION['correo'] = $usuario['correo'];
        $_SESSION['rol'] = $usuario['rol'];
        header("Location: ../views/dashboard/paciente.php");
        exit();
    } else {
        $_SESSION['error'] = "Correo o contraseña incorrectos.";
        header("Location: ../views/auth/login.php");
        exit();
    }
} 

// --- ACCESO NO AUTORIZADO ---
else {
    header("Location: ../views/auth/login.php");
    exit();
}
?>