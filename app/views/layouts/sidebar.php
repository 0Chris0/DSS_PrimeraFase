<?php

// ==============================
// VALIDAR SESIÓN
// Verificar que exista usuario logueado
// ==============================

if(
    !isset($_SESSION['usuario']) ||
    !isset($_SESSION['rol'])
){

    // Redireccionar al login
    header(
    "Location: /SistemaCitasMedicas/app/views/auth/login.php"
    );

    exit();
}

?>



<!-- ==============================
SIDEBAR / MENÚ LATERAL
Visible en todas las pantallas
============================== -->

<div class="sidebar">

    <!-- Título del sistema -->
    <h2>Sistema Médico</h2>

    <ul>

        <!-- Opción principal -->
        <li><a href="#">Inicio</a></li>



        <!-- ==============================
        MENÚ PARA ADMINISTRADOR
        ============================== -->

        <?php if($_SESSION['rol'] == 'administrador'): ?>

            <li><a href="#">Pacientes</a></li>

            <li><a href="#">Médicos</a></li>

            <li><a href="#">Citas Médicas</a></li>

            <li><a href="#">Reportes</a></li>

            <li><a href="#">Consultas</a></li>

            <li>
                <a href="#">
                    Calificación de Servicio
                </a>
            </li>

            <li><a href="#">Configuración</a></li>



        <!-- ==============================
        MENÚ PARA DOCTOR
        ============================== -->

        <?php elseif($_SESSION['rol'] == 'doctor'): ?>

            <li><a href="#">Mis Citas</a></li>

            <li>
                <a href="#">
                    Historial Médico
                </a>
            </li>

            <li><a href="#">Consultas</a></li>



        <!-- ==============================
        MENÚ PARA PACIENTE
        ============================== -->

        <?php elseif($_SESSION['rol'] == 'paciente'): ?>

            <li>
                <a href="#">
                    Programar Cita
                </a>
            </li>

            <li><a href="#">Mis Citas</a></li>

            <li>
                <a href="#">
                    Calificación de Servicio
                </a>
            </li>

        <?php endif; ?>



        <!-- ==============================
        CERRAR SESIÓN
        ============================== -->

        <li>

            <a href="/SistemaCitasMedicas/logout.php">

                Cerrar Sesión

            </a>

        </li>

    </ul>



    <!-- ==============================
    INFORMACIÓN DEL USUARIO
    ============================== -->

    <div class="usuario-info">

        <!-- Mostrar correo del usuario -->
        <p>
            Usuario:
            <?= $_SESSION['usuario'] ?>
        </p>

        <!-- Mostrar rol actual -->
        <p>
            Rol:
            <?= $_SESSION['rol'] ?>
        </p>

    </div>

</div>