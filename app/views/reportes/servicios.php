<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Servicios Más Solicitados</title>

    <link rel="stylesheet" href="../../../public/css/reportesPages.css">
     <link rel="stylesheet" href="../../../public/css/registrospacientes.css">
    <link rel="stylesheet" href="../../../public/css/pacientes.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>

    <?php include __DIR__ . '/../layouts/header.php'; ?>
    <?php include __DIR__ . '/../layouts/sidebarPaciente.php'; ?>

    <div class="main-content">

        <div class="breadcrumb">
            Inicio / Reportes / <strong>Servicios Más Solicitados</strong>
        </div>

        <h1 class="page-title">Servicios Más Solicitados</h1>

        <div class="stats-grid">

            <div class="stat-card">

                <i class="fa-solid fa-stethoscope"></i>

                <h3>Consulta General</h3>

                <p>120 solicitudes</p>

            </div>

            <div class="stat-card">

                <i class="fa-solid fa-heart-pulse"></i>

                <h3>Cardiología</h3>

                <p>85 solicitudes</p>

            </div>

            <div class="stat-card">

                <i class="fa-solid fa-tooth"></i>

                <h3>Odontología</h3>

                <p>60 solicitudes</p>

            </div>

        </div>

    </div>
<?php include __DIR__ . '/../layouts/scriptsPacientes.php'; ?>
</body>

</html>