<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Lista de Citas</title>
    <link rel="stylesheet" href="../../../public/css/citas.css">
    <link rel="stylesheet" href="../../../public/css/registrospacientes.css">
    <link rel="stylesheet" href="../../../public/css/pacientes.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>

    <?php include __DIR__ . '/../layouts/header.php'; ?>
    <?php include __DIR__ . '/../layouts/sidebarPaciente.php'; ?>
    <div class="main-content">

        <div class="breadcrumb">
            Inicio / Citas / <strong>Lista de Citas</strong>
        </div>

        <h1 class="page-title">Lista de Citas</h1>

        <div class="card">

            <div class="card-header">
                Consulta, edita y gestiona todas las citas programadas
            </div>

            <div class="table-actions">

                <div class="search-box">

                    <i class="fa-solid fa-magnifying-glass"></i>

                    <input type="text" placeholder="Buscar paciente o médico...">

                </div>

                <a href="create.php" class="btn-add">
                    <i class="fa-solid fa-plus"></i>
                    Agregar Cita
                </a>

            </div>

            <table>

                <thead>

                    <tr>
                        <th>Paciente</th>
                        <th>Médico</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Estado</th> <th>Acciones</th>
                    </tr>

                </thead>

                <tbody>

                    <tr class="row-completed">
                        <td>María Pérez</td>
                        <td>Dr. Hernández</td>
                        <td>24/04/2026</td>
                        <td>08:00 AM</td>
                        <td>
                            <span class="badge badge-completed">Completada</span>
                        </td>
                        <td class="actions">
                            <a href="../calificaciones/index.php" class="btn-calificar" title="Calificar Servicio">
                                <i class="fa-solid fa-star star-icon"></i>
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td>Roberto Martínez</td>
                        <td>Dra. Vargas</td>
                        <td>25/04/2026</td>
                        <td>09:30 AM</td>
                        <td>
                            <span class="badge badge-scheduled">Programada</span>
                        </td>
                        <td class="actions">
                            <a href="edit.php">
                                <i class="fa-solid fa-pen-to-square edit"></i>
                            </a>
                            <i class="fa-solid fa-trash delete"></i>
                        </td>
                    </tr>

                    <tr>
                        <td>Laura Torres</td>
                        <td>Dra. Gómez</td>
                        <td>25/04/2026</td>
                        <td>11:00 AM</td>
                        <td>
                            <span class="badge badge-scheduled">Programada</span>
                        </td>
                        <td class="actions">
                            <a href="edit.php">
                                <i class="fa-solid fa-pen-to-square edit"></i>
                            </a>
                            <i class="fa-solid fa-trash delete"></i>
                        </td>
                    </tr>

                </tbody>

            </table>

            <div class="pagination">

                <span>Página 1 de 5</span>

                <div class="pages">

                    <button>
                        <i class="fa-solid fa-angles-left"></i>
                    </button>

                    <button class="active">1</button>
                    <button>2</button>
                    <button>3</button>

                    <button>
                        <i class="fa-solid fa-angles-right"></i>
                    </button>

                </div>

            </div>

        </div>

    </div>

    <?php include __DIR__ . '/../layouts/scriptsPacientes.php'; ?>

</body>

</html>