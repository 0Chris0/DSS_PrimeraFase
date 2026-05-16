<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Reportes</title>

    <link rel="stylesheet" href="../../../public/css/registrospacientes.css">
    <link rel="stylesheet" href="../../../public/css/pacientes.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        /* Contenedor principal de la cuadrícula */
        .reportes-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            /* Crea exactamente 2 columnas iguales */
            gap: 24px;
            /* Espaciado limpio entre tarjetas */
            margin-top: 20px;
            font-family: 'Poppins', sans-serif;
        }

        /* ESTRUCTURA DE LAS TARJETAS (CARDS) */
        .reporte-card {
            background: #ffffff;
            border-radius: 8px;
            padding: 24px;
            border: 1px solid #d9d9d9;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.06);
            /* Sombra suave idéntica a tu diseño */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: flex-end;
            /* Alinea el botón "Ver Reporte" hacia la derecha */
            position: relative;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        /* Efecto al pasar el cursor sobre la tarjeta */
        .reporte-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }

        /* Bloque contenedor de icono + textos */
        .reporte-info {
            display: flex;
            align-items: flex-start;
            gap: 20px;
            width: 100%;
            margin-bottom: 16px;
        }

        /* Contenedor de textos */
        .reporte-text {
            flex: 1;
            text-align: left;
            /* Asegura la alineación del texto a la izquierda */
        }

        .reporte-text h3 {
            margin: 0 0 6px 0;
            font-size: 18px;
            font-weight: 600;
            color: #1450b8;
            /* El azul corporativo de tus títulos */
        }

        .reporte-text p {
            margin: 0;
            font-size: 14px;
            color: #55627c;
            /* Gris azulado para descripciones */
            line-height: 1.4;
        }

        /* ICONOS Y VARIACIONES DE COLOR */
        .reporte-img {
            width: 90px;
            height: 90px;
            object-fit: contain;
        }

        .reporte-icon.blue {
            color: #3b82f6;
            /* Azul para citas y médicos */
        }

        .reporte-icon.orange {
            color: #f97316;
            /* Naranja para historiales y barras */
        }

        .reporte-icon.yellow {
            color: #eab308;
            /* Dorado para estrellas */
        }

        /* BOTONES CON DEGRADADO ESTILO CÁPSULA */
        .btn-reporte {
            background: linear-gradient(135deg, #4481eb 0%, #04befe 100%);
            /* Degradado azul vibrante */
            color: #ffffff;
            text-decoration: none;
            padding: 8px 18px;
            border-radius: 50px;
            /* Bordes redondeados estilo píldora */
            font-size: 13px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 8px rgba(4, 190, 254, 0.3);
            transition: all 0.3s ease;
        }

        .btn-reporte i {
            font-size: 12px;
            transition: transform 0.2s ease;
        }

        /* Animación interactiva en el botón */
        .btn-reporte:hover {
            background: linear-gradient(135deg, #3b71d4 0%, #03a9df 100%);
            box-shadow: 0 5px 12px rgba(4, 190, 254, 0.4);
            transform: scale(1.03);
        }

        /* Pequeño empuje de la flecha al pasar el mouse */
        .btn-reporte:hover i {
            transform: translateX(4px);
        }

        /* RESPONSIVE DESIGN (DISEÑO ADAPTABLE) */
        @media (max-width: 992px) {
            .reportes-grid {
                gap: 16px;
            }
        }

        @media (max-width: 768px) {

            /* En móviles las tarjetas se apilan en una sola columna */
            .reportes-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .reporte-card {
                padding: 20px;
            }
        }
    </style>

</head>

<body>

    <?php include __DIR__ . '/../layouts/header.php'; ?>
    <?php include __DIR__ . '/../layouts/sidebarPaciente.php'; ?>

    <div class="main-content">

        <div class="breadcrumb">
            Inicio / <strong>Reportes</strong>
        </div>

        <h1 class="page-title">Reportes</h1>

        <div class="reportes-grid">

            <div class="reporte-card">
                <div class="reporte-info">
                    <img src="../../../public/img/programadas.png" class="reporte-img">
                    <div class="reporte-text">
                        <h3>Citas Programadas</h3>
                        <p>Listado de citas programadas en el sistema</p>
                    </div>
                </div>
                <a href="../../views/citas/index.php" class="btn-reporte">
                    Ver Reporte
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <div class="reporte-card">
                <div class="reporte-info">
                    <img src="../../../public/img/historial.png" class="reporte-img">
                    <div class="reporte-text">
                        <h3>Historial de Atención</h3>
                        <p>Historial de consultas de los pacientes</p>
                    </div>
                </div>
                <a href="../../views/reportes/historial.php" class="btn-reporte">
                    Ver Reporte
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <div class="reporte-card">
                <div class="reporte-info">
                   <img src="../../../public/img/medico4.png" class="reporte-img">
                    <div class="reporte-text">
                        <h3>Pacientes por Médico</h3>
                        <p>Pacientes atendidos por cada médico</p>
                    </div>
                </div>
                <a href="../../views/reportes/pacientesMedico.php" class="btn-reporte">
                    Ver Reporte
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <div class="reporte-card">
                <div class="reporte-info">
                    <img src="../../../public/img/Servicios.png" class="reporte-img">
                    <div class="reporte-text">
                        <h3>Servicios Más Solicitados</h3>
                        <p>Servicios médicos más demandados</p>
                    </div>
                </div>
                <a href="../../views/reportes/servicios.php" class="btn-reporte">
                    Ver Reporte
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <div class="reporte-card">
                <div class="reporte-info">
                    <img src="../../../public/img/Atencion.png" class="reporte-img">
                    <div class="reporte-text">
                        <h3>Atención por Especialidad</h3>
                        <p>Consultas y atención por especialistas médicos</p>
                    </div>
                </div>
                <a href="../../views/reportes/especialidades.php" class="btn-reporte">
                    Ver Reporte
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <div class="reporte-card">
                <div class="reporte-info">
                    <img src="../../../public/img/calificacion.png" class="reporte-img">
                    <div class="reporte-text">
                        <h3>Calificaciones de Servicios</h3>
                        <p>Valoraciones sobre los servicios recibidos</p>
                    </div>
                </div>
                <a href="../../views/reportes/calificaciones.php" class="btn-reporte">
                    Ver Reporte
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

        </div>

    </div>

    <?php include __DIR__ . '/../layouts/scriptsPacientes.php'; ?>

</body>

</html>