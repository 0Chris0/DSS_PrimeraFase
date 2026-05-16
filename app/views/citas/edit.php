<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar Cita</title>

    <link rel="stylesheet" href="../../../public/css/editarcita.css">
     <link rel="stylesheet" href="../../../public/css/pacientes.css">
    <link rel="stylesheet" href="../../../public/css/registrospacientes.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>
  <!-- HEADER -->
    <?php include __DIR__ . '/../layouts/header.php'; ?>

    <!-- SIDEBAR -->
    <?php include __DIR__ . '/../layouts/sidebarPaciente.php'; ?>
    <div class="main-content">

        <div class="breadcrumb">
            Inicio / Citas / <strong>Editar Cita</strong>
        </div>

        <h1 class="page-title">Editar Cita</h1>

        <div class="card">

            <div class="card-header">
                Editar información de la cita
            </div>

            <form class="form-grid">

                <div class="form-group">

                    <label>Fecha</label>

                    <input type="date" value="2026-04-25">

                </div>

                <div class="form-group">

                    <label>Hora</label>

                    <input type="time" value="09:30">

                </div>

                <div class="form-group">

                    <label>Paciente</label>

                    <input type="text" value="Carlos Gómez">

                </div>

                <div class="form-group">

                    <label>Médico</label>

                    <input type="text" value="Dra. Vargas">

                </div>

                <div class="form-group full">

                    <label>Motivo de Consulta</label>

                    <textarea>Chequeo general</textarea>

                </div>

                <div class="buttons">

                    <button class="btn-cancel" type="button">

                        <i class="fa-solid fa-xmark"></i>
                        Cancelar

                    </button>

                    <button class="btn-save" type="submit">

                        <i class="fa-solid fa-floppy-disk"></i>
                        Guardar Cambios

                    </button>

                </div>

            </form>

        </div>

    </div>

    <?php include __DIR__ . '/../layouts/scriptsPacientes.php'; ?>

</body>

</html>