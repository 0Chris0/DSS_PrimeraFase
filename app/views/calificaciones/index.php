<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Calificación de Servicio</title>

<link rel="stylesheet" href="../../../public/css/calificaciones.css">
<link rel="stylesheet" href="../../../public/css/pacientes.css">
<link rel="stylesheet" href="../../../public/css/registrospacientes.css
">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>

<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php include __DIR__ . '/../layouts/sidebarPaciente.php'; ?>

<div class="main-content">

    <!-- BREADCRUMB -->
    <div class="breadcrumb">
        Inicio / Citas / <strong>Calificar Servicios</strong>
    </div>

    <!-- TITULO -->
    <h1 class="page-title">
        Calificación de Servicio
    </h1>

    <!-- CARD -->
    <div class="rating-card">

        <!-- INFO -->
        <div class="service-info">

            <p>
                <strong>Médico:</strong>
                Dr. Hernández
            </p>

            <p>
                <strong>Fecha:</strong>
                24 de abril de 2026 a las 08:00 AM
            </p>

            <p>
                <strong>Motivo:</strong>
                Consulta General
            </p>

        </div>

        <!-- LINEA -->
        <div class="divider"></div>

        <!-- PREGUNTA -->
        <h2 class="question">
            ¿Cómo calificarías la atención recibida<br>
            por el Dr. Hernández?
        </h2>

        <!-- ESTRELLAS -->
        <div class="stars" id="stars">

    <i class="fa-solid fa-star" data-value="1"></i>
    <i class="fa-solid fa-star" data-value="2"></i>
    <i class="fa-solid fa-star" data-value="3"></i>
    <i class="fa-solid fa-star" data-value="4"></i>
    <i class="fa-solid fa-star" data-value="5"></i>

</div>

<input type="hidden" id="rating" value="0">

        <!-- COMENTARIOS -->
        <div class="comment-box">

            <label>Comentarios</label>

            <textarea placeholder="Escribe un comentario...."></textarea>

        </div>

        <!-- BOTONES -->
        <div class="buttons">

            <button class="btn-cancel" type="button">

                <i class="fa-solid fa-xmark"></i>
                Cancelar

            </button>

            <button class="btn-send" type="submit">

                <i class="fa-solid fa-paper-plane"></i>
                Enviar Comentario

            </button>

        </div>

    </div>

</div>

<?php include __DIR__ . '/../layouts/scriptsPacientes.php'; ?>
<script>

const stars = document.querySelectorAll('#stars i');
const ratingInput = document.getElementById('rating');

stars.forEach((star, index) => {

    star.addEventListener('click', () => {

        let rating = index + 1;

        ratingInput.value = rating;

        stars.forEach((s, i) => {

            if(i < rating){
                s.classList.add('active');
            }else{
                s.classList.remove('active');
            }

        });

    });

});

</script>
</body>
</html>