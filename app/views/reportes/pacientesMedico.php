<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pacientes por Médico</title>

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
            Inicio / Reportes / <strong>Pacientes por Médico</strong>
        </div>

        <h1 class="page-title">Pacientes por Médico</h1>

        <div class="table-card">

            <table>

                <thead>

                    <tr>
                        <th>Médico</th>
                        <th>Especialidad</th>
                        <th>Pacientes Atendidos</th>
                        
                    </tr>

                </thead>

                <tbody>

                    <tr>
                        <td>Dr. Hernández</td>
                        <td>General</td>
                        <td>45</td>
                        
                    </tr>

                    <tr>
                        <td>Dra. Vargas</td>
                        <td>Cardiología</td>
                        <td>32</td>
                        
                    </tr>

                </tbody>

            </table>

        </div>

    </div>
<?php include __DIR__ . '/../layouts/scriptsPacientes.php'; ?>
</body>

</html>