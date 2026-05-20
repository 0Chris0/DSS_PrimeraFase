<?php 
session_start(); 
require_once __DIR__ . '/../../controllers/CitasController.php';
$controller = new CitasController();

// CORRECCIÓN: Ahora procesamos la eliminación mediante POST para mayor seguridad
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $controller->eliminarCita($_POST['id']);
    header("Location: index.php");
    exit();
}

$citas = $controller->listarCitas();
?>
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
                Consulta, edita y gestiona todas las citas programadas dinámicamente
            </div>

            <div class="table-actions">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Buscar paciente o médico...">
                </div>
                <a href="create.php" class="btn-add">
                    <i class="fa-solid fa-plus"></i> Agregar Cita
                </a>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Médico asignado</th>
                        <th>Especialidad</th>
                        <th>Fecha de la Cita</th>
                        <th>Estado</th> 
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($citas)): ?>
                        <tr>
                            <td colspan="6" style="text-align:center;">No hay citas registradas en Postgres.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($citas as $cita): ?>
                            <tr>
                                <td>#<?= $cita['id_cita'] ?></td>
                                <td><strong><?= htmlspecialchars($cita['nombre_medico']) ?></strong></td>
                                <td><?= htmlspecialchars($cita['nombre_especialidad']) ?></td>
                                <td><i class="fa-regular fa-calendar"></i> <?= date('d/m/Y', strtotime($cita['fecha_cita'])) ?></td>
                                <td>
                                    <span class="badge badge-scheduled">Programada</span>
                                </td>
                                <td class="actions">
                                    <a href="edit.php?id=<?= $cita['id_cita'] ?>">
                                        <i class="fa-solid fa-pen-to-square edit"></i>
                                    </a>
                                    <a href="index.php?action=delete&id=<?= $cita['id_cita'] ?>" onclick="return confirm('¿Seguro que deseas eliminar esta cita?');">
                                        <i class="fa-solid fa-trash delete"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include __DIR__ . '/../layouts/scriptsPacientes.php'; ?>
</body>
</html>