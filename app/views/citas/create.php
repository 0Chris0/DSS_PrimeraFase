<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Programar Cita</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../../../public/css/programarcita.css">
    <link rel="stylesheet" href="../../../public/css/pacientes.css">
    <link rel="stylesheet" href="../../../public/css/registrospacientes.css">

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
            <span>Citas</span>
            <span>/</span>

            <strong>Programar Cita</strong>

        </div>

        <!-- TITULO -->
        <h1 class="page-title">
            Programar Cita
        </h1>

        <!-- CARD -->
        <div class="registro-card">

            <!-- HEADER CARD -->
            <div class="card-header">
                Completa el formulario para registrar una nueva cita
            </div>

            <!-- FORM -->
            <form class="registro-form">

                <div class="form-grid">

                    <!-- COLUMNA IZQUIERDA -->
                    <div class="form-col">

                        <!-- FECHA -->
                        <div class="form-group">

                            <label>Fecha</label>

                            <div class="input-icon">

                                <i class="fa-regular fa-calendar"
                                    onclick="document.getElementById('fechaInput').showPicker()"></i>

                               <input type="text" id="fechaInput" placeholder="Seleccionar fecha" readonly>

                            </div>

                        </div>

                        <!-- CALENDARIO -->
                        <div class="calendar-box">

                            <div class="calendar-header">
                                abril 2026
                            </div>

                            <div class="calendar-grid">

                                <div class="day-name">Do</div>
                                <div class="day-name">Lu</div>
                                <div class="day-name">Ma</div>
                                <div class="day-name">Mi</div>
                                <div class="day-name">Ju</div>
                                <div class="day-name">Vi</div>
                                <div class="day-name">Sa</div>

                                <div onclick="seleccionarFecha(2,this)">2</div>
                                <div onclick="seleccionarFecha(3,this)">3</div>
                                <div onclick="seleccionarFecha(4,this)">4</div>
                                <div onclick="seleccionarFecha(5,this)">5</div>
                                <div onclick="seleccionarFecha(6,this)">6</div>
                                <div onclick="seleccionarFecha(7,this)">7</div>
                                <div onclick="seleccionarFecha(8,this)">8</div>

                                <div onclick="seleccionarFecha(9,this)">9</div>
                                <div onclick="seleccionarFecha(10,this)">10</div>
                                <div onclick="seleccionarFecha(11,this)">11</div>
                                <div onclick="seleccionarFecha(12,this)">12</div>
                                <div onclick="seleccionarFecha(13,this)">13</div>
                                <div onclick="seleccionarFecha(14,this)">14</div>
                                <div onclick="seleccionarFecha(15,this)">15</div>

                                <div onclick="seleccionarFecha(16,this)">16</div>
                                <div onclick="seleccionarFecha(17,this)">17</div>
                                <div onclick="seleccionarFecha(18,this)">18</div>
                                <div onclick="seleccionarFecha(19,this)">19</div>
                                <div onclick="seleccionarFecha(20,this)">20</div>
                                <div onclick="seleccionarFecha(21,this)">21</div>
                                <div onclick="seleccionarFecha(22,this)">22</div>

                                <div onclick="seleccionarFecha(23,this)">23</div>
                                <div onclick="seleccionarFecha(24,this)">24</div>
                                <div onclick="seleccionarFecha(25,this)">25</div>
                                <div onclick="seleccionarFecha(26,this)">26</div>
                                <div onclick="seleccionarFecha(27,this)">27</div>
                                <div onclick="seleccionarFecha(28,this)">28</div>
                                <div onclick="seleccionarFecha(29,this)">29</div>

                                <div onclick="seleccionarFecha(30,this)">30</div>
                                <div onclick="seleccionarFecha(31,this)">31</div>

                            </div>

                        </div>

                    </div>

                    <!-- COLUMNA DERECHA -->
                    <div class="form-col">

                        <!-- HORA -->
                        <div class="form-group">

                            <label>Hora</label>

                            <div class="input-icon">

                                <i class="fa-regular fa-clock"
                                    onclick="document.getElementById('horaInput').showPicker()"></i>

                                <input type="time" id="horaInput">

                            </div>

                        </div>

                        <!-- PACIENTE -->
                        <div class="form-group">

                            <label>Paciente</label>

                            <div class="input-icon">

                                <i class="fa-regular fa-user"></i>

                                <input type="text" value="Carlos Gómez">

                            </div>

                        </div>

                        <!-- MEDICO -->
                        <div class="form-group">

                            <label>Médico</label>

                            <div class="input-icon">

                                <i class="fa-solid fa-user-doctor"></i>

                                <input type="text" value="Dra. Vargas (Cardiología)">

                            </div>

                        </div>

                        <!-- MOTIVO -->
                        <div class="form-group">

                            <label>Motivo de la Consulta</label>

                            <div class="motivo-box">

                                <i class="fa-solid fa-pencil"></i>

                                <textarea></textarea>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- NOTAS -->
                <div class="notes-section">

                    <label>Notas</label>

                    <textarea placeholder="Notas adicionales sobre el médico"></textarea>

                </div>

                <!-- BOTONES -->
                <div class="buttons">

                    <button class="btn-cancel" type="button">

                        <i class="fa-solid fa-xmark"></i>

                        Cancelar

                    </button>

                    <button class="btn-save" type="submit">

                        <i class="fa-regular fa-calendar-check"></i>

                        Programar Cita

                    </button>

                </div>

            </form>

        </div>

    </div>

    <!-- SCRIPTS -->
    <?php include __DIR__ . '/../layouts/scriptsPacientes.php'; ?>

    <script>

function seleccionarFecha(dia,elemento){

    // quitar selección anterior
    document.querySelectorAll('.calendar-grid div')
    .forEach(el=>el.classList.remove('active-day'));

    // activar nuevo
    elemento.classList.add('active-day');

    // colocar fecha en input
    const fecha = `2026-04-${String(dia).padStart(2,'0')}`;

    document.getElementById('fechaInput').value = fecha;
}

</script>
</body>

</html>