<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consultas</title>
    <link rel="stylesheet" href="../../../public/css/pacientes.css">
    <link rel="stylesheet" href="../../../public/css/registrospacientes.css">
    <link rel="stylesheet" href="../../../public/css/consultas.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <?php include __DIR__ . '/../layouts/header.php'; ?>
    <?php include __DIR__ . '/../layouts/sidebarPaciente.php'; ?>

    <div class="main-content">
        <div class="breadcrumb">Inicio / <strong>Consultas</strong></div>
        <h1 class="page-title">Consultas</h1>
        <div class="consulta-info">Realiza consultas en el sistema para obtener información específica.</div>

        <div class="consultas-grid">
            <div class="consulta-card green">
                <form action="resultados_paciente.php" method="GET">
                    <div class="consulta-header"><img src="../../../public/img/paciente2.png"> <span>Buscar Pacientes</span></div>
                    <div class="consulta-body">
                        <div class="input-box">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" name="nombre_paciente" placeholder="Nombre del paciente" required>
                        </div>
                        <button type="submit">Ver Historial</button>
                    </div>
                </form>
            </div>

            <div class="consulta-card cyan">
                <form action="resultados_citas.php" method="GET">
                    <div class="consulta-header">
                        <img src="../../../public/img/citas2.png"> <span>Buscar Citas</span>
                    </div>
                    <div class="consulta-body">
                        <div class="input-box">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" name="nombre_paciente" placeholder="Nombre del paciente" required>
                        </div>
                        <button type="submit">Buscar Citas</button>
                    </div>
                </form>
            </div>

            <div class="consulta-card blue">
                <form action="resultados_medico.php" method="GET">
                    <div class="consulta-header"><img src="../../../public/img/Medicos.png"> <span>Buscar Médicos</span></div>
                    <div class="consulta-body">
                        <div class="input-box">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" name="nombre_medico" placeholder="Nombre del médico" required>
                        </div>
                        <button type="submit">Buscar Citas del Médico</button>
                    </div>
                </form>
            </div>

            <div class="consulta-card red">
                <form action="resultados.php" method="GET">
                    <input type="hidden" name="tipo" value="reportes">
                    <div class="consulta-header"><img src="../../../public/img/estadistico.png"> <span>Buscar Reportes</span></div>
                    <div class="consulta-body">
                        <div class="input-box"><i class="fa-solid fa-magnifying-glass"></i><input type="text" name="q" placeholder="Palabra clave"></div>
                        <button type="submit">Buscar Reportes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php include __DIR__ . '/../layouts/scriptsPacientes.php'; ?>
</body>
</html>