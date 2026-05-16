<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Calendario de Citas</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../../../public/css/programarcita.css">
    <link rel="stylesheet" href="../../../public/css/pacientes.css">
    <link rel="stylesheet" href="../../../public/css/registrospacientes.css">

    <!-- GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- FONT AWESOME -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>

        .calendar-wrapper{
            background: #fff;
            border-radius: 18px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.06);
        }

        .calendar-top{
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .calendar-top h2{
            font-size: 22px;
            font-weight: 600;
            color: #1e293b;
        }

        .calendar-buttons{
            display: flex;
            gap: 10px;
        }

        .calendar-buttons button{
            width: 40px;
            height: 40px;
            border: none;
            border-radius: 10px;
            background: #2563eb;
            color: white;
            cursor: pointer;
            font-size: 16px;
            transition: .2s;
        }

        .calendar-buttons button:hover{
            background: #1d4ed8;
        }

        .calendar-grid{
            display: grid;
            grid-template-columns: repeat(7,1fr);
            gap: 12px;
        }

        .day-name{
            text-align: center;
            font-weight: 600;
            color: #64748b;
            padding-bottom: 10px;
        }

        .calendar-day{
            height: 90px;
            background: #f8fafc;
            border-radius: 15px;
            padding: 10px;
            cursor: pointer;
            transition: .2s;
            position: relative;
            border: 2px solid transparent;
        }

        .calendar-day:hover{
            background: #eff6ff;
            transform: translateY(-3px);
        }

        .calendar-day.active{
            border: 2px solid #2563eb;
            background: #dbeafe;
        }

        .calendar-day span{
            font-weight: 600;
            color: #1e293b;
        }

        .calendar-event{
            margin-top: 8px;
            font-size: 11px;
            background: #2563eb;
            color: white;
            padding: 4px 6px;
            border-radius: 8px;
        }

        .empty{
            background: transparent;
            cursor: default;
        }

        .appointments{
            margin-top: 30px;
        }

        .appointments h3{
            margin-bottom: 20px;
            color: #1e293b;
        }

        .appointment-card{
            background: #f8fafc;
            border-left: 5px solid #2563eb;
            padding: 15px;
            border-radius: 14px;
            margin-bottom: 15px;
        }

        .appointment-card strong{
            display: block;
            margin-bottom: 5px;
            color: #1e293b;
        }

        .appointment-card p{
            margin: 3px 0;
            color: #64748b;
            font-size: 14px;
        }

    </style>

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

            <strong>Calendario</strong>

        </div>

        <!-- TITULO -->
        <h1 class="page-title">
            Calendario de Citas
        </h1>

        <!-- CARD -->
        <div class="registro-card">

            <div class="card-header">
                Visualiza y administra tus citas médicas
            </div>

            <div class="calendar-wrapper">

                <!-- TOP -->
                <div class="calendar-top">

                    <h2 id="monthYear"></h2>

                    <div class="calendar-buttons">

                        <button onclick="cambiarMes(-1)">
                            <i class="fa-solid fa-chevron-left"></i>
                        </button>

                        <button onclick="cambiarMes(1)">
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>

                    </div>

                </div>

                <!-- CALENDARIO -->
                <div class="calendar-grid" id="calendar">

                </div>

            </div>

            <!-- CITAS -->
            <div class="appointments">

                <h3>
                    Próximas Citas
                </h3>

                <div class="appointment-card">

                    <strong>Dra. Vargas - Cardiología</strong>

                    <p>
                        <i class="fa-regular fa-calendar"></i>
                        18 Mayo 2026
                    </p>

                    <p>
                        <i class="fa-regular fa-clock"></i>
                        10:30 AM
                    </p>

                </div>

                <div class="appointment-card">

                    <strong>Dr. Hernández - Pediatría</strong>

                    <p>
                        <i class="fa-regular fa-calendar"></i>
                        24 Mayo 2026
                    </p>

                    <p>
                        <i class="fa-regular fa-clock"></i>
                        02:00 PM
                    </p>

                </div>

            </div>

        </div>

    </div>

    <!-- SCRIPTS -->
    <?php include __DIR__ . '/../layouts/scriptsPacientes.php'; ?>

    <script>

        const calendar = document.getElementById("calendar");

        const monthYear = document.getElementById("monthYear");

        let fechaActual = new Date();

        const meses = [
            "Enero","Febrero","Marzo","Abril","Mayo","Junio",
            "Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"
        ];

        function renderCalendar(){

            calendar.innerHTML = "";

            const year = fechaActual.getFullYear();

            const month = fechaActual.getMonth();

            monthYear.textContent = `${meses[month]} ${year}`;

            const primerDia = new Date(year, month, 1).getDay();

            const ultimoDia = new Date(year, month + 1, 0).getDate();

            // NOMBRES DIAS
            const dias = ["Do","Lu","Ma","Mi","Ju","Vi","Sa"];

            dias.forEach(dia => {

                const div = document.createElement("div");

                div.classList.add("day-name");

                div.textContent = dia;

                calendar.appendChild(div);

            });

            // ESPACIOS VACIOS
            for(let i = 0; i < primerDia; i++){

                const empty = document.createElement("div");

                empty.classList.add("empty");

                calendar.appendChild(empty);

            }

            // DIAS
            for(let dia = 1; dia <= ultimoDia; dia++){

                const div = document.createElement("div");

                div.classList.add("calendar-day");

                div.innerHTML = `
                    <span>${dia}</span>
                `;

                // EJEMPLO EVENTOS
                if(dia == 18 || dia == 24){

                    const event = document.createElement("div");

                    event.classList.add("calendar-event");

                    event.textContent = "Cita Médica";

                    div.appendChild(event);

                }

                div.onclick = function(){

                    document.querySelectorAll('.calendar-day')
                    .forEach(d => d.classList.remove('active'));

                    div.classList.add('active');

                }

                calendar.appendChild(div);

            }

        }

        function cambiarMes(valor){

            fechaActual.setMonth(fechaActual.getMonth() + valor);

            renderCalendar();

        }

        renderCalendar();

    </script>

</body>

</html>