<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detalle Paciente</title>

    <link rel="stylesheet" href="../../../public/css/pacientes.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>

        .detail-container{
            margin-top:90px;
            padding:25px;
        }

        .detail-card{
            background:white;
            border-radius:10px;
            padding:35px;
            max-width:850px;
            margin:auto;
            box-shadow:0 2px 10px rgba(0,0,0,0.08);
        }

        .detail-title{
            color:#0068a5;
            margin-bottom:30px;
        }

        .detail-grid{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:25px;
        }

        .detail-item{
            background:#f5f7fb;
            padding:18px;
            border-radius:8px;
        }

        .detail-item span{
            display:block;
            font-size:13px;
            color:#64748b;
            margin-bottom:5px;
        }

        .detail-item strong{
            font-size:16px;
            color:#0f172a;
        }

    </style>

</head>

<body>

<?php include __DIR__ . '/../layouts/header.php'; ?>

<?php include __DIR__ . '/../layouts/sidebarPaciente.php'; ?>

<div class="main-content detail-container">

    <div class="detail-card">

        <h1 class="detail-title">
            Información del Paciente
        </h1>

        <div class="detail-grid">

            <div class="detail-item">
                <span>Nombre</span>
                <strong>Maria</strong>
            </div>

            <div class="detail-item">
                <span>Apellido</span>
                <strong>Pérez</strong>
            </div>

            <div class="detail-item">
                <span>Teléfono</span>
                <strong>7000-0000</strong>
            </div>

            <div class="detail-item">
                <span>Correo</span>
                <strong>maria@gmail.com</strong>
            </div>

            <div class="detail-item">
                <span>Sexo</span>
                <strong>Femenino</strong>
            </div>

            <div class="detail-item">
                <span>Dirección</span>
                <strong>San Salvador</strong>
            </div>

        </div>

    </div>

</div>
  <?php include __DIR__ . '/../layouts/scriptsPacientes.php'; ?>
</body>

</html>