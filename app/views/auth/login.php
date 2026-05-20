<?php
session_start();

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login — Citas Médicas</title>

    <link rel="stylesheet"
    href="../../../public/css/login.css">

    <!-- ICONOS -->
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
    
<body>

<div class="container-auth">

    <!-- LOGO Y TITULO -->
    <div class="top-content">

        <img src="../../../public/img/logo.png"
        class="logo">

        <div class="title-system">
            Citas Médicas
        </div>

    </div>

    <!-- CARD LOGIN -->
    <div class="card-auth">

        <div class="form-title">
            Iniciar Sesion
        </div>

        <!-- MENSAJES -->
        <?php if(isset($_SESSION['error'])): ?>
            <div class="error-box">
                <?= $_SESSION['error'] ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?php if(isset($_SESSION['success'])): ?>
            <div class="success-box">
                <?= $_SESSION['success'] ?>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <!-- FORMULARIO -->
        <form action="../../controllers/AuthController.php"
        method="POST">

            <input type="hidden"
                   name="accion"
                   value="login">

            <input type="hidden"
                   name="csrf_token"
                   value="<?= $_SESSION['csrf_token'] ?>">

            <!-- CORREO -->
            <div class="input-group">

                <i class="fa-solid fa-user"></i>

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

            <!-- LINK -->
            <div class="forgot-password">
                <a href="#">
                    ¿Olvidaste tu Contraseña?
                </a>
            </div>

            <!-- BOTON -->
            <button type="submit"
            class="btn-auth">

                Iniciar Sesion

            </button>

            <!-- REGISTRO -->
            <div class="links">

                ¿No tienes cuenta?
                <br>

                <a href="register.php">
                    Crear Cuenta
                </a>

            </div>

        </form>

    </div>

</div>

</body>
</html>

