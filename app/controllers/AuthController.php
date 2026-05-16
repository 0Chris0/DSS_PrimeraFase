<?php

// Mostrar errores durante desarrollo
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Iniciar sesión para usar variables SESSION
session_start();


// Conexión PDO a la base de datos
require_once __DIR__ . '/../../config/conexion.php';

// Modelo Usuario donde están las consultas SQL
require_once __DIR__ . '/../models/Usuario.php';


// Crear objeto del modelo Usuario
$usuarioModel = new Usuario($conexion);


// Verificar si viene una acción desde formulario
if(isset($_POST['accion'])){


    // ==============================
    // VALIDACIÓN CSRF
    // Protección básica de formularios
    // ==============================

    if(
        !isset($_POST['csrf_token']) ||
        !isset($_SESSION['csrf_token']) ||
        $_POST['csrf_token'] !== $_SESSION['csrf_token']
    ){

        // Mensaje de error
        $_SESSION['error'] = "Solicitud no válida";

        // Redireccionar al login
        header("Location: ../views/auth/login.php");
        exit();
    }


    // Eliminar token después de usarlo
    unset($_SESSION['csrf_token']);



    // ==============================
    // REGISTRO DE USUARIO
    // ==============================

    if($_POST['accion'] == 'registrar'){

        // Evitar inyección HTML/XSS
        $correo = htmlspecialchars($_POST['correo']);


        // Validar confirmación contraseña
        if($_POST['password'] !== $_POST['confirmar_password']){

            $_SESSION['error'] =
            "Las contraseñas no coinciden";

            header("Location: ../views/auth/register.php");
            exit();
        }


        // Encriptar contraseña con BCRYPT
        $password = password_hash(
            $_POST['password'],
            PASSWORD_BCRYPT
        );


        // Rol por defecto del usuario registrado
        $rol = "paciente";


        // TRY-CATCH para manejar errores
        try {

            // Registrar usuario en BD
            $usuarioModel->registrar(
                $correo,
                $password,
                $rol
            );

            // Mensaje éxito
            $_SESSION['success'] =
            "Usuario registrado correctamente";

            // Redireccionar login
            header("Location: ../views/auth/login.php");
            exit();


        } catch(PDOException $e){

            // Error si correo ya existe
            $_SESSION['error'] =
            "El correo ya está registrado";

            header("Location: ../views/auth/register.php");
            exit();
        }
    }



    // ==============================
    // LOGIN DE USUARIO
    // ==============================

    if($_POST['accion'] == 'login'){

        // Limpiar correo
        $correo = htmlspecialchars($_POST['correo']);

        // Obtener contraseña
        $password = $_POST['password'];


        // Buscar usuario por correo
        $usuario = $usuarioModel->buscarCorreo($correo);


        // Verificar usuario y contraseña
        if(
            $usuario &&
            password_verify($password, $usuario['password'])
        ){

            // Variables de sesión
            $_SESSION['usuario'] =
            $usuario['correo'];

            $_SESSION['id'] =
            $usuario['id_usuario'];

            $_SESSION['rol'] =
            $usuario['rol'];


            // ==============================
            // CONTROL DE ROLES
            // ==============================

            // Administrador
            if($usuario['rol'] == 'administrador'){

                header(
                "Location: ../views/dashboard/admin.php"
                );

            // Doctor
            } elseif($usuario['rol'] == 'doctor'){

                header(
                "Location: ../views/dashboard/doctor.php"
                );

            // Paciente
            } elseif($usuario['rol'] == 'paciente'){

                header(
                "Location: ../views/dashboard/paciente.php"
                );
            }

            exit();


        } else {

            // Error login incorrecto
            $_SESSION['error'] =
            "Correo o contraseña incorrectos";

            header("Location: ../views/auth/login.php");
            exit();
        }
    }
}

?>