<?php
session_start();
require_once __DIR__ . '/../../../config/conexion.php';

try {
    $countMedicos = $conexion->query("SELECT COUNT(*) FROM medicos")->fetchColumn();
    $countPacientes = $conexion->query("SELECT COUNT(*) FROM pacientes")->fetchColumn();
    
    if ($countMedicos == 0 && $countPacientes == 0) {
        $tablas = $conexion->query("SELECT table_name FROM information_schema.tables WHERE table_schema = 'public'")->fetchAll(PDO::FETCH_COLUMN);
        echo "";
    }

    $countCitas = $conexion->query("SELECT COUNT(*) FROM citas WHERE DATE(fecha_cita) = CURRENT_DATE")->fetchColumn();
    $countReportes = $conexion->query("SELECT COUNT(*) FROM reportes")->fetchColumn();

} catch (PDOException $e) {
    die("Error de conexión o consulta: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Paciente</title>
    <link rel="stylesheet" href="../../../public/css/pacientes.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <div class="sidebar-overlay" id="sidebar-overlay"></div>
    <!-- HEADER SUPERIOR -->
    <?php include __DIR__ . '/../layouts/header.php'; ?>
    <?php include __DIR__ . '/../layouts/sidebarPaciente.php'; ?>
    <div class="main-content" id="main-content">

        <div class="welcome-banner">
            <div class="welcome-text">
                <!-- BUSCADOR -->
                <div class="banner-search">

                    <i class="fa-solid fa-magnifying-glass"></i>

                    <input type="text" placeholder="Buscar pacientes, médicos o citas...">

                </div>
                <h1>¡Te damos la bienvenida!</h1>
                <p>Este es el panel principal del sistema de citas médicas.</p>
                <p>Utiliza el menu lateral para navegar.</p>

            </div>
        </div>

        <div class="shortcuts-grid">
            <div class="shortcut-card blue-grad">
                <i class="fa-solid fa-stethoscope"></i>
                <a href="../../views/medicos/index.php">Ver Médicos</a>
            </div>
            <div class="shortcut-card green-grad">
                <i class="fa-solid fa-user-injured"></i>
                <a href="../../views/pacientes/index.php">Ver Pacientes</a>
            </div>
            <div class="shortcut-card cyan-grad">
                <i class="fa-solid fa-calendar-plus"></i>
                <a href="../../views/citas/create.php">Programar Cita</a>
            </div>
            <div class="shortcut-card red-grad">
                <i class="fa-solid fa-chart-bar"></i>
                <a href="../../views/reportes/index.php">Ver Reportes</a>
            </div>
        </div>

        <div class="dashboard-layout">

            <!-- SECCIÓN IZQUIERDA -->
            <div class="left-section">
                <div class="stats-bar">

                    <div class="stat-item">

                        <div class="stat-icon-box blue">
                            <img src="../../../public/img/doctor.png">
                        </div>

                        <div class="stat-info">
                            <span class="num"><?php echo $countMedicos; ?></span>
                            <span class="lab">Médicos</span>
                            <span class="sub">Registrados</span>
                        </div>

                    </div>

                    <div class="stat-item">

                        <div class="stat-icon-box green">
                            <img src="../../../public/img/paciente.png">
                        </div>

                        <div class="stat-info">
                            <span class="num"><?php echo $countPacientes; ?></span>
                            <span class="lab">Pacientes</span>
                            <span class="sub">Registrados</span>
                        </div>

                    </div>

                    <div class="stat-item">

                        <div class="stat-icon-box cyan">
                            <img src="../../../public/img/calendario.png">
                        </div>

                        <div class="stat-info">
                            <span class="num"><?php echo $countCitas; ?></span>
                            <span class="lab">Citas</span>
                            <span class="sub">Para Hoy</span>
                        </div>

                    </div>

                    <div class="stat-item">

                        <div class="stat-icon-box red">
                            <img src="../../../public/img/reportes.png">
                        </div>

                        <div class="stat-info">
                            <span class="num"><?php echo $countReportes; ?></span>
                            <span class="lab">Reportes</span>
                            <span class="sub">Generados</span>
                        </div>

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
                        <div class="time-col">08:00 <span>AM</span>
                            <div class="dot green"></div>
                        </div>
                        <div class="info-col"><strong>Ana López</strong><br><span class="status-text green">● Consulta General</span></div>
                    </div>
                    <div class="agenda-item">
                        <div class="time-col">09:30 <span>AM</span>
                            <div class="dot green"></div>
                        </div>
                        <div class="info-col"><strong>Roberto Martinez</strong><br><span class="status-text green">● Chequeo Cardio</span></div>
                    </div>
                    <div class="agenda-item">
                        <div class="time-col">11:00 <span>AM</span>
                            <div class="dot yellow"></div>
                        </div>
                        <div class="info-col"><strong>Maria Pérez</strong><br><span class="tag yellow">Pendiente</span></div>
                    </div>
                </div>
                <button class="btn-agenda">Ver Agenda</button>
            </div>
        </div>
    </div>
    <?php include __DIR__ . '/../layouts/scriptsPacientes.php'; ?>
</body>

</html>