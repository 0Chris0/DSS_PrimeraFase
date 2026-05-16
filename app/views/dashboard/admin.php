<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

// Middleware de seguridad
require_once __DIR__ . '/../../middleware/AuthMiddleware.php';

if($_SESSION['rol'] !== 'paciente'){
    header("Location: ../auth/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Paciente - EduGestión Escolar</title>
    <link rel="stylesheet" href="../../../public/css/pacientes.css">
    <!-- Importación de pesos gruesos para el diseño imponente -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

<!-- Header Superior Azul (image_730520.png) -->
<div class="header-top-blue">
    <div class="header-left">
        <img src="../img/image_730520.png" alt="Logo" class="header-logo">
        <span class="system-name">Citas Médicas</span>
    </div>
    <div class="header-right">
        <div class="user-profile">
            <i class="fa-solid fa-circle-user"></i>
            <span>Usuario</span>
        </div>
    </div>
</div>

<div class="sidebar" id="sidebar">
    <div class="logo">
        <button class="menu-toggle" id="menu-toggle"><i class="fa-solid fa-bars"></i></button>
        <div class="logo-title"><i class="fa-solid fa-hospital"></i> <span>Menú</span></div>
    </div>
    <ul>
        <li class="active"><a href="#"><i class="fa-solid fa-house"></i> <span>Inicio</span></a></li>
        <li><a href="#"><i class="fa-solid fa-user-group"></i> <span>Pacientes</span></a></li>
        <li><a href="#"><i class="fa-solid fa-stethoscope"></i> <span>Médicos</span></a></li>
        <li><a href="#"><i class="fa-solid fa-calendar-check"></i> <span>Citas Médicas</span></a></li>
        <li><a href="#"><i class="fa-solid fa-chart-column"></i> <span>Reportes</span></a></li>
    </ul>
    <div class="bottom-menu">
        <a href="#"><i class="fa-solid fa-gear"></i> <span>Configuración</span></a>
    </div>
</div>

<div class="main-content" id="main-content">
    
    <!-- Banner de bienvenida con fondo personalizado (image_731c7c.png) -->
    <div class="welcome-banner">
        <div class="welcome-text">
            <h1>¡Te damos la bienvenida!</h1>
            <p>Este es el panel principal del sistema de citas médicas.</p>
        </div>
    </div>

     <!-- Sección de Accesos Rápidos (Captura de pantalla 2026-05-12 180654.png) -->
    <div class="shortcuts-grid">
        <div class="shortcut-card blue-grad">
            <i class="fa-solid fa-stethoscope"></i>
            <a href="#">Ver Médicos</a>
        </div>
        <div class="shortcut-card green-grad">
            <i class="fa-solid fa-user-injured"></i>
            <a href="#">Ver Pacientes</a>
        </div>
        <div class="shortcut-card cyan-grad">
            <i class="fa-solid fa-calendar-plus"></i>
            <a href="#">Programar Cita</a>
        </div>
        <div class="shortcut-card red-grad">
            <i class="fa-solid fa-chart-bar"></i>
            <a href="#">Ver Reportes</a>
        </div>
    </div>

    <!-- Contenedor Flex para separar la Agenda del resto -->
    <div class="dashboard-layout">
        
        <!-- SECCIÓN IZQUIERDA -->
        <div class="left-section">
            <!-- Barra de estadísticas con fuentes gruesas -->
            <div class="stats-bar">
                <div class="stat-item">
                    <div class="stat-icon-box blue"><i class="fa-solid fa-user-doctor"></i></div>
                    <div class="stat-info"><span class="num">12</span><span class="lab">MÉDICOS</span></div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon-box green"><i class="fa-solid fa-hospital-user"></i></div>
                    <div class="stat-info"><span class="num">28</span><span class="lab">PACIENTES</span></div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon-box cyan"><i class="fa-solid fa-calendar-check"></i></div>
                    <div class="stat-info"><span class="num">8</span><span class="lab">CITAS</span></div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon-box red"><i class="fa-solid fa-file-waveform"></i></div>
                    <div class="stat-info"><span class="num">6</span><span class="lab">REPORTES</span></div>
                </div>
            </div>

            <div class="panel activity-panel">
                <div class="panel-header">
                    <h3>Actividad Reciente</h3>
                    <div class="panel-dots"><span></span><span></span></div>
                </div>
                <div class="activity-row">
                    <i class="fa-solid fa-calendar-check icon-blue"></i>
                    <p><strong>Maria Hernandez</strong> agendó una cita con <strong>Dr. Gonzales</strong> para el 25 de abril de 2026</p>
                </div>
                <div class="activity-row">
                    <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" class="mini-avatar">
                    <p><strong>Carlos Gómez</strong> registró un nuevo paciente:<br><small>hace 1 hora</small></p>
                </div>
                <div class="activity-row">
                    <img src="https://cdn-icons-png.flaticon.com/512/2785/2785482.png" class="mini-avatar">
                    <p><strong>Dr. Hernandez</strong> completó una cita con <strong>Ana López</strong><br><small>hace 2 horas</small></p>
                </div>
            </div>
        </div>

        <!-- SECCIÓN DERECHA (AGENDA LARGA) -->
        <div class="panel agenda-panel">
            <div class="panel-header">
                <h3 class="blue-title">Agenda del Día</h3>
                <div class="panel-dots"><span></span><span></span></div>
            </div>
            <div class="agenda-list">
                <div class="agenda-item">
                    <div class="time-col">08:00 <span>AM</span><div class="dot green"></div></div>
                    <div class="info-col"><strong>Ana López</strong><br><span class="status-text green">● Consulta General</span></div>
                </div>
                <div class="agenda-item">
                    <div class="time-col">09:30 <span>AM</span><div class="dot green"></div></div>
                    <div class="info-col"><strong>Roberto Martinez</strong><br><span class="status-text green">● Chequeo Cardio</span></div>
                </div>
                <div class="agenda-item">
                    <div class="time-col">11:00 <span>AM</span><div class="dot yellow"></div></div>
                    <div class="info-col"><strong>Maria Pérez</strong><br><span class="tag yellow">Pendiente</span></div>
                </div>
            </div>
            <button class="btn-agenda">Ver Agenda</button>
        </div>
    </div>
</div>

<script>
    const toggle = document.getElementById("menu-toggle");
    const sidebar = document.getElementById("sidebar");
    const main = document.getElementById("main-content");
    toggle.addEventListener("click", () => {
        sidebar.classList.toggle("hide");
        main.classList.toggle("full");
    });
</script>
</body>
</html>