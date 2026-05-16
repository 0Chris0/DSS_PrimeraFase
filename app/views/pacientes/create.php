<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Registrar Paciente</title>

    <link rel="stylesheet" href="../../../public/css/pacientes.css">
     <link rel="stylesheet" href="../../../public/css/registrospacientes.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>

    <!-- HEADER -->
    <?php include __DIR__ . '/../layouts/header.php'; ?>

    <!-- SIDEBAR -->
    <?php include __DIR__ . '/../layouts/sidebarPaciente.php'; ?>

    <!-- CONTENIDO -->
    <div class="main-content" id="main-content">

        <!-- BREADCRUMB -->
        <div class="breadcrumb">

            <span>Inicio</span>
            <span>/</span>

            <span>Pacientes</span>
            <span>/</span>

            <strong>Registrar Paciente</strong>

        </div>

        <!-- TITULO -->
        <h1 class="page-title">
            Registro de Pacientes
        </h1>

        <!-- CARD -->
        <div class="registro-card">

            <!-- HEADER -->
            <div class="card-header">

                Completa el siguiente formulario para registrar un nuevo paciente

            </div>

            <!-- FORM -->
            <form class="registro-form">

                <div class="form-grid">

                    <!-- IZQUIERDA -->
                    <div class="form-col">

                        <div class="form-group">

                            <label>Nombre</label>

                            <div class="input-icon">

                                <i class="fa-solid fa-user"></i>

                                <input type="text" placeholder="Maria">

                            </div>

                        </div>

                        <div class="form-group">

                            <label>Apellido</label>

                            <div class="input-icon">

                                <i class="fa-solid fa-user"></i>

                                <input type="text" placeholder="Pérez">

                            </div>

                        </div>

                        <div class="form-group">

                            <label>DUI/ Documento</label>

                            <div class="input-icon">

                                <i class="fa-solid fa-id-card"></i>

                                <input type="text" placeholder="01234567-8">

                            </div>

                        </div>

                        <div class="form-group">

                            <label>Teléfono</label>

                            <div class="input-icon">

                                <i class="fa-solid fa-phone"></i>

                                <input type="text" placeholder="(503) 7000-0000">

                            </div>

                        </div>

                    </div>

                    <!-- DERECHA -->
                    <div class="form-col right-col">

                        <div class="form-group">

                            <label>Fecha de nacimiento</label>

                            <div class="input-icon">

                                <i class="fa-solid fa-calendar-days"></i>

                                <input type="date">

                            </div>

                        </div>

                        <div class="form-group">

                            <label>Sexo</label>

                            <div class="input-icon">

                                <i class="fa-solid fa-user"></i>

                                <select>

                                    <option>Femenino</option>
                                    <option>Masculino</option>

                                </select>

                            </div>

                        </div>

                        <div class="form-group">

                            <label>Correo Electrónico</label>

                            <div class="input-icon">

                                <i class="fa-solid fa-envelope"></i>

                                <input type="email" placeholder="maria.perez@gmail.com">

                            </div>

                        </div>

                        <div class="form-group">

                            <label>Dirección</label>

                            <div class="input-icon">

                                <i class="fa-solid fa-location-dot"></i>

                                <input type="text" placeholder="San Salvador, El Salvador">

                            </div>

                        </div>

                    </div>

                </div>

                <!-- NOTAS -->
                <div class="notes-section">

                    <label>Notas</label>

                    <textarea placeholder="Notas adicionales sobre el paciente"></textarea>

                </div>

                <!-- BOTONES -->
                <div class="buttons">

                    <button type="button" class="btn btn-cancel">

                        <i class="fa-solid fa-xmark"></i>

                        Cancelar

                    </button>

                    <button type="submit" class="btn btn-save">

                        <i class="fa-solid fa-floppy-disk"></i>

                        Guardar

                    </button>

                </div>

            </form>

        </div>

    </div>

    <!-- SCRIPT -->
    <?php include __DIR__ . '/../layouts/scriptsPacientes.php'; ?>

</body>

</html>