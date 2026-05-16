<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Lista Médicos</title>

    <link rel="stylesheet" href="../../../public/css/pacientes.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        .table-container {
            margin-top: 90px;
            padding: 25px;
        }

        .patients-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .patients-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .patients-header h1 {
            color: #0068a5;
        }

        .btn-add {
            background: #1f57b7;
            color: white;
            padding: 12px 18px;
            border-radius: 7px;
            text-decoration: none;
            font-weight: 600;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th {
            background: #1f57b7;
            color: white;
            padding: 14px;
        }

        table td {
            padding: 14px;
            border-bottom: 1px solid #e5e7eb;
        }

        .actions {
            display: flex;
            gap: 10px;
        }

        .btn-action {
            width: 35px;
            height: 35px;
            border: none;
            border-radius: 6px;
            color: white;

            display: flex;
            justify-content: center;
            align-items: center;

            text-decoration: none;
        }

        .view {
            background: #17a2b8;
        }

        .edit {
            background: #f39c12;
        }

        .delete {
            background: #e74c3c;
        }
    </style>

</head>

<body>

    <?php include __DIR__ . '/../layouts/header.php'; ?>

    <?php include __DIR__ . '/../layouts/sidebarPaciente.php'; ?>

    <div class="main-content table-container">

        <div class="patients-card">

            <div class="patients-header">

                <h1>Lista de Médicos</h1>

                <a href="create.php" class="btn-add">
                    <i class="fa-solid fa-user-plus"></i>
                    Nuevo Médico
                </a>

            </div>

            <table>

                <thead>

                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Especialidad</th>
                        <th>Teléfono</th>
                        <th>Acciones</th>
                    </tr>

                </thead>

                <tbody>

                    <tr>

                        <td>1</td>
                        <td>Dr. Carlos Martinez</td>
                        <td>Cardiología</td>
                        <td>7000-0000</td>

                        <td>

                            <div class="actions">

                                <a href="show.php" class="btn-action view">
                                    <i class="fa-solid fa-eye"></i>
                                </a>

                                <a href="edit.php" class="btn-action edit">
                                    <i class="fa-solid fa-pen"></i>
                                </a>

                                <button class="btn-action delete">
                                    <i class="fa-solid fa-trash"></i>
                                </button>

                            </div>

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>
      <?php include __DIR__ . '/../layouts/scriptsPacientes.php'; ?>

</body>

</html>