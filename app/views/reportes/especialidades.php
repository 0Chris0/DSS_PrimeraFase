<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Atención por Especialidad</title>

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
            Inicio / Reportes / <strong>Atención por Especialidad</strong>
        </div>

        <h1 class="page-title">Atención por Especialidad</h1>

        <div class="table-card">

            <table>

                <thead>

                    <tr>
                        <th>Especialidad</th>
                        <th>Total Consultas</th>
                        <th>Médicos</th>
                        
                    </tr>

                </thead>

                <tbody>

                    <tr>
                        <td>Cardiología</td>
                        <td>85</td>
                        <td>3</td>
                        
                    </tr>

                    <tr>
                        <td>Pediatría</td>
                        <td>60</td>
                        <td>2</td>
                        
                    </tr>
                      <tr>
                        <td>Dermatología</td>
                        <td>40</td>
                        <td>1</td>
                        
                    </tr>

                </tbody>

            </table>

        </div>

    </div>
<?php include __DIR__ . '/../layouts/scriptsPacientes.php'; ?>
</body>

</html>