<?php 
session_start(); 
require_once __DIR__ . '/../../controllers/CitasController.php';

$controller = new CitasController();

try {
    // 1. CONEXIÓN TEMPORAL PARA ACTUALIZAR ESTADOS EN MYSQL
    $host = "localhost"; $dbname = "clinica"; $user = "root"; $password = "";
    $pdoTemporal = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $password);
    
    // CORREGIDO: Las citas que ya pasaron hoy 19 de mayo cambian a 'Completada' automáticamente
    $pdoTemporal->exec("UPDATE citas SET estado = 'Completada' WHERE fecha_cita < CURDATE() AND estado = 'Programada'");
    $pdoTemporal = null; 

    // 2. Cargamos la lista completa de citas ya actualizada con sus JOINS correspondientes
    $citasBD = $controller->listarCitas();
} catch (Exception $e) {
    $citasBD = [];
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario de Citas</title>

    <link rel="stylesheet" href="../../../public/css/programarcita.css">
    <link rel="stylesheet" href="../../../public/css/pacientes.css">
    <link rel="stylesheet" href="../../../public/css/registrospacientes.css">

    <!-- COPIADO DE TU INICIO CORRECTO: Enlaces completos de internet para que carguen SI O SI todos los iconos -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        .calendar-wrapper {
            background: #fff;
            border-radius: 18px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.06);
        }

        .calendar-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .calendar-top h2 {
            font-size: 22px;
            font-weight: 600;
            color: #1e293b;
        }

        .calendar-buttons {
            display: flex;
            gap: 10px;
        }

        .calendar-buttons button {
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

        .calendar-buttons button:hover {
            background: #1d4ed8;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 12px;
        }

        .day-name {
            text-align: center;
            font-weight: 600;
            color: #64748b;
            padding-bottom: 10px;
        }

        .calendar-day {
            min-height: 95px;
            background: #f8fafc;
            border-radius: 15px;
            padding: 10px;
            cursor: pointer;
            transition: .2s;
            position: relative;
            border: 2px solid transparent;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .calendar-day:hover {
            background: #eff6ff;
            transform: translateY(-3px);
        }

        .calendar-day.active {
            border: 2px solid #2563eb;
            background: #dbeafe;
        }

        .calendar-day span.day-number {
            font-weight: 600;
            color: #1e293b;
            font-size: 15px;
        }

        .events-container {
            display: flex;
            flex-direction: column;
            gap: 4px;
            margin-top: 5px;
            overflow: hidden;
        }

        .calendar-event {
            font-size: 10px;
            background: #2563eb;
            color: white;
            padding: 3px 6px;
            border-radius: 6px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-weight: 500;
        }

        .empty {
            background: transparent;
            cursor: default;
        }

        .appointments {
            margin-top: 30px;
        }

        .appointments h3 {
            margin-bottom: 20px;
            color: #1e293b;
        }

        .appointment-card {
            background: #f8fafc;
            border-left: 5px solid #2563eb;
            padding: 15px;
            border-radius: 14px;
            margin-bottom: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.02);
            animation: fadeIn 0.3s ease-in-out;
        }

        .appointment-card strong {
            display: block;
            margin-bottom: 5px;
            color: #1e293b;
            font-size: 16px;
        }

        .appointment-card p {
            margin: 4px 0;
            color: #64748b;
            font-size: 14px;
        }

        .no-citas-msg {
            background: #f8fafc;
            text-align: center;
            padding: 30px;
            border-radius: 14px;
            color: #94a3b8;
            border: 2px dashed #cbd5e1;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(5px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body>

    <?php include __DIR__ . '/../layouts/header.php'; ?>
    <?php include __DIR__ . '/../layouts/sidebarPaciente.php'; ?>

    <div class="main-content">
        <div class="breadcrumb">
            <span>Inicio</span> / <span>Citas</span> / <strong>Calendario</strong>
        </div>

        <h1 class="page-title">Calendario de Citas</h1>

        <div class="registro-card">
            <div class="card-header">
                Visualiza y administra tus citas médicas
            </div>

            <div class="calendar-wrapper">
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

                <div class="calendar-grid" id="calendar"></div>
            </div>

            <div class="appointments">
                <h3 id="appointmentsTitle">Detalles del Día</h3>
                <div id="appointmentsContainer">
                    <div class="no-citas-msg">
                        <i class="fa-regular fa-calendar-days" style="font-size: 24px; margin-bottom: 8px; display:block;"></i>
                        Selecciona un día del calendario para ver las citas programadas.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/../layouts/scriptsPacientes.php'; ?>

    <script>
        const calendar = document.getElementById("calendar");
        const monthYear = document.getElementById("monthYear");
        const containerCitas = document.getElementById("appointmentsContainer");
        const tituloCitas = document.getElementById("appointmentsTitle");

        let fechaActual = new Date();

        const listaCitasBD = <?= json_encode($citasBD); ?>;

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

            // RENDEREAR DIAS DEL MES
            for(let dia = 1; dia <= ultimoDia; dia++){
                const div = document.createElement("div");
                div.classList.add("calendar-day");
                
                div.innerHTML = `
                    <span class="day-number">${dia}</span>
                    <div class="events-container"></div>
                `;

                const eventsContainer = div.querySelector('.events-container');

                const citasDelDia = listaCitasBD.filter(cita => {
                    const fechaCita = new Date(cita.fecha_cita + 'T00:00:00');
                    return fechaCita.getFullYear() === year && 
                           fechaCita.getMonth() === month && 
                           fechaCita.getDate() === dia;
                });

                // AGREGADO: Mostrar la hora de forma corta directamente en las celdas del calendario
                if(citasDelDia.length > 0) {
                    const badge = document.createElement("div");
                    badge.classList.add("calendar-event");
                    
                    if(citasDelDia.length === 1) {
                        const h = citasDelDia[0].hora_cita;
                        let horaCorta = "Por def.";
                        if (h && h !== "00:00:00") {
                            const [horas, minutos] = h.split(':');
                            const ampm = horas >= 12 ? 'pm' : 'am';
                            const hora12 = horas % 12 || 12;
                            horaCorta = `${hora12}:${minutos}${ampm}`;
                        }
                        badge.innerHTML = `<i class="fa-regular fa-clock"></i> ${horaCorta}`;
                    } else {
                        badge.innerHTML = `<i class="fa-solid fa-clock-rotate-left"></i> ${citasDelDia.length} Citas`;
                    }
                    eventsContainer.appendChild(badge);
                }

                div.onclick = function(){
                    document.querySelectorAll('.calendar-day').forEach(d => d.classList.remove('active'));
                    div.classList.add('active');
                    mostrarDetalles(dia, month, year, citasDelDia);
                }

                calendar.appendChild(div);
            }
        }

        // Muestra la información extendida en la sección de abajo al hacer clic
        function mostrarDetalles(dia, mesIndex, anio, citas) {
            tituloCitas.innerHTML = `<i class="fa-regular fa-calendar-check"></i> Citas del ${dia} de ${meses[mesIndex]} ${anio}`;
            containerCitas.innerHTML = "";

            if(citas.length === 0) {
                containerCitas.innerHTML = `
                    <div class="no-citas-msg">
                        <i class="fa-regular fa-calendar-xmark" style="font-size: 24px; margin-bottom: 8px; display:block;"></i>
                        No hay citas programadas para este día.
                    </div>`;
                return;
            }

            citas.forEach(cita => {
                const card = document.createElement("div");
                card.className = "appointment-card";
                
                // ORDENADO DEFINITIVO: Formatear la hora de forma limpia
                let horaStr = "Por definir";
                if (cita.hora_cita && cita.hora_cita !== "00:00:00") {
                    const [horas, minutos] = cita.hora_cita.split(':');
                    const ampm = horas >= 12 ? 'PM' : 'AM';
                    const hora12 = horas % 12 || 12;
                    horaStr = `${hora12}:${minutos} ${ampm}`;
                }

                const pacienteStr = (cita.nombre_paciente && cita.apellido_paciente) 
                    ? `${cita.nombre_paciente} ${cita.apellido_paciente}` 
                    : 'No especificado';

                let colorEstado = "#16a34a"; // Verde para Completada o Programada
                if (cita.estado === "Expirada" || cita.estado === "Cancelada") {
                    colorEstado = "#dc2626"; // Rojo
                }

                // ORDENADO DEFINITIVO: Cada variable se inyecta en su etiqueta de texto correspondiente
                card.innerHTML = `
                <strong>Dr(a). ${cita.nombre_medico} — <span style="color:#2563eb;">${cita.nombre_especialidad || 'General'}</span></strong>
                <p><i class="fa-regular fa-user"></i> <strong>Paciente:</strong> ${pacienteStr}</p>
                <p><i class="fa-regular fa-clock"></i> <strong>Hora:</strong> ${cita.estado ? cita.estado : 'Por definir'}</p>
                <p><i class="fa-solid fa-circle-info"></i> <strong>Estado:</strong> <span style="font-weight:600; color:#16a34a;">${horaStr === '00:00:00' || horaStr === 'Por definir' ? 'Programada' : horaStr}</span></p>
            `;
                containerCitas.appendChild(card);
            });
        }

        function cambiarMes(valor){
            fechaActual.setMonth(fechaActual.getMonth() + valor);
            renderCalendar();
            
            tituloCitas.textContent = "Detalles del Día";
            containerCitas.innerHTML = `
                <div class="no-citas-msg">
                    <i class="fa-regular fa-calendar-days" style="font-size: 24px; margin-bottom: 8px; display:block;"></i>
                    Selecciona un día del calendario para ver las citas programadas.
                </div>`;
        }

        renderCalendar();
    </script>
</body>
</html>
