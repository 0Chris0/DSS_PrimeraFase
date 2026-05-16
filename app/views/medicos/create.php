<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Registrar Médico</title>

    <link rel="stylesheet" href="../../../public/css/pacientes.css">

    <link rel="stylesheet" href="../../../public/css/registrospacientes.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>

<?php include __DIR__ . '/../layouts/header.php'; ?>

<?php include __DIR__ . '/../layouts/sidebarPaciente.php'; ?>

<div class="main-content">

    <div class="breadcrumb">
        <span>Inicio</span>
        <span>/</span>
        <span>Médicos</span>
        <span>/</span>
        <strong>Registrar Médico</strong>
    </div>

    <h1 class="page-title">
        Registro de Médicos
    </h1>

    <div class="registro-card">

        <div class="card-header">
            Completa el siguiente formulario para registrar un nuevo médico
        </div>

        <form class="registro-form">

            <div class="form-grid">

                <div class="form-col">

                    <div class="form-group">
                        <label>Nombre</label>

                        <div class="input-icon">
                            <i class="fa-solid fa-user"></i>
                            <input type="text" placeholder="Carlos">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Apellido</label>

                        <div class="input-icon">
                            <i class="fa-solid fa-user"></i>
                            <input type="text" placeholder="Martinez">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Especialidad</label>

                        <div class="input-icon">
                            <i class="fa-solid fa-stethoscope"></i>
                            <input type="text" placeholder="Cardiología">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Teléfono</label>

                        <div class="input-icon">
                            <i class="fa-solid fa-phone"></i>
                            <input type="text" placeholder="7000-0000">
                        </div>
                    </div>

                </div>

                <div class="form-col right-col">

                    <div class="form-group">
                        <label>Fecha de nacimiento</label>

                        <div class="input-icon">
                            <i class="fa-solid fa-calendar"></i>
                            <input type="date">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Sexo</label>

                        <div class="input-icon">
                            <i class="fa-solid fa-user-doctor"></i>

                            <select>
                                <option>Masculino</option>
                                <option>Femenino</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Correo Electrónico</label>

                        <div class="input-icon">
                            <i class="fa-solid fa-envelope"></i>
                            <input type="email" placeholder="doctor@gmail.com">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Dirección</label>

                        <div class="input-icon">
                            <i class="fa-solid fa-location-dot"></i>
                            <input type="text" placeholder="San Salvador">
                        </div>
                    </div>

                </div>

            </div>

            <div class="notes-section">

                <label>Notas</label>

                <textarea placeholder="Notas adicionales sobre el médico"></textarea>

            </div>

            <div class="buttons">

                <button class="btn btn-cancel" type="button">
                    <i class="fa-solid fa-xmark"></i>
                    Cancelar
                </button>

                <button class="btn btn-save" type="submit">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Guardar
                </button>

            </div>

        </form>

    </div>

</div>
  <?php include __DIR__ . '/../layouts/scriptsPacientes.php'; ?>
</body>

</html>