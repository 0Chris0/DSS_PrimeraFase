<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Consultas</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../../../public/css/pacientes.css">
    <link rel="stylesheet" href="../../../public/css/registrospacientes.css">
    <link rel="stylesheet" href="../../../public/css/consultas.css">

    <!-- GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- FONT AWESOME -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>

    <!-- HEADER -->
    <?php include __DIR__ . '/../layouts/header.php'; ?>

    <!-- SIDEBAR -->
    <?php include __DIR__ . '/../layouts/sidebarPaciente.php'; ?>

    <!-- CONTENIDO -->
    <div class="main-content">

        <!-- BREADCRUMB -->
        <div class="breadcrumb">

            <span>Inicio</span>
            <span>/</span>

            <strong>Consultas</strong>

        </div>

        <!-- TITULO -->
        <h1 class="page-title">
            Consultas
        </h1>

        <!-- INFO -->
        <div class="consulta-info">

            Realiza consultas en el sistema de citas médicas para obtener información específica

        </div>

        <!-- GRID -->
        <div class="consultas-grid">

            <!-- PACIENTES -->
            <div class="consulta-card green">

                <div class="consulta-header">

                    <img src="../../../public/img/paciente2.png">

                    <span>Buscar Pacientes</span>

                </div>

                <div class="consulta-body">

                    <div class="input-box">

                        <i class="fa-solid fa-magnifying-glass"></i>

                        <input type="text" placeholder="Buscar Pacientes">

                    </div>

                    <button>
                        Buscar Pacientes
                    </button>

                </div>

            </div>

            <!-- CITAS -->
            <div class="consulta-card cyan">

                <div class="consulta-header">

                    <img src="../../../public/img/citas2.png">

                    <span>Buscar Citas</span>

                </div>

                <div class="consulta-body">

                    <div class="input-box">

                        <i class="fa-solid fa-magnifying-glass"></i>

                        <input type="text" placeholder="Nombre del paciente o médico">

                    </div>

                    <button>
                        Buscar Citas
                    </button>

                </div>

            </div>

            <!-- MEDICOS -->
            <div class="consulta-card blue">

                <div class="consulta-header">

                    <img src="../../../public/img/Medicos.png">

                    <span>Buscar Médicos</span>

                </div>

                <div class="consulta-body">

                    <div class="input-box">

                        <i class="fa-solid fa-magnifying-glass"></i>

                        <input type="text" placeholder="Nombre o especialidad">

                    </div>

                    <button>
                        Buscar Médicos
                    </button>

                </div>

            </div>

            <!-- REPORTES -->
            <div class="consulta-card red">

                <div class="consulta-header">

                    <img src="../../../public/img/estadistico.png">

                    <span>Buscar Reportes</span>

                </div>

                <div class="consulta-body">

                    <div class="input-box">

                        <i class="fa-solid fa-magnifying-glass"></i>

                        <input type="text" placeholder="Palabra clave o descripción">

                    </div>

                    <button>
                        Buscar Reportes
                    </button>

                </div>

            </div>

        </div>

    </div>

    <!-- SCRIPTS -->
    <?php include __DIR__ . '/../layouts/scriptsPacientes.php'; ?>

</body>

</html>