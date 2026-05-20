<?php
session_start();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro — Citas Médicas</title>

    <link rel="stylesheet"
    href="../../../public/css/register.css">

    <!-- ICONOS -->
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>

<div class="container-auth">

    <!-- LOGO -->
    <div class="top-content">

        <img src="../../../public/img/logo.png"
        class="logo">

        <div class="title-system">
            Citas Médicas
        </div>

    </div>

    <!-- FORMULARIO -->
    <div class="card-auth">

        <div class="form-title">
            Crear Cuenta
        </div>

        <!-- MENSAJES -->
        <?php if(isset($_SESSION['error'])): ?>
            <div class="error-box">
                <?= $_SESSION['error'] ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <!-- FORM -->
        <form action="../../controllers/AuthController.php"
        method="POST">

            <input type="hidden"
                   name="accion"
                   value="registrar">

            <!-- CORREO -->
            <div class="input-group">

                <i class="fa-solid fa-envelope"></i>

                <input type="email"
                       name="correo"
                       placeholder="Correo electrónico"
                       required>

            </div>

            <!-- PASSWORD -->
            <div class="input-group">

                <i class="fa-solid fa-lock"></i>

                <input type="password"
                       name="password"
                       placeholder="Contraseña"
                       required>

            </div>

            <!-- CONFIRMAR -->
            <div class="input-group">

                <i class="fa-solid fa-lock"></i>

                <input type="password"
                       name="confirmar_password"
                       placeholder="Confirmar Contraseña"
                       required>

            </div>

            <!-- BOTON -->
            <button type="submit"
            class="btn-auth">

                Registrarse

            </button>

            <!-- LOGIN -->
            <div class="bottom-links">

                ¿Ya tienes cuenta?
                <br>

                <a href="login.php">
                    Iniciar Sesión
                </a>

            </div>

        </form>

    </div>

</div>

</body>
</html>
