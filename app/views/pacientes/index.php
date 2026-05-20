<?php
$_GET['accion'] = 'listar';
require_once '../../controllers/PacienteController.php';

$pacientes = $_SESSION['pacientes'] ?? [];
unset($_SESSION['pacientes']);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pacientes</title>
    <link rel="stylesheet" href="../../../public/css/pacientes.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        .table-container { margin-top: 90px; padding: 25px; }
        .patients-card { background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08); }
        .patients-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .patients-header h1 { color: #0068a5; }
        .btn-add { background: #1f57b7; color: white; padding: 12px 18px; border-radius: 7px; text-decoration: none; font-weight: 600; }
        table { width: 100%; border-collapse: collapse; }
        table th { background: #1f57b7; color: white; padding: 14px; text-align: left; }
        table td { padding: 14px; border-bottom: 1px solid #e5e7eb; }
        .actions { display: flex; gap: 10px; }
        .btn-action { width: 35px; height: 35px; border: none; border-radius: 6px; color: white; cursor: pointer; }
        .view { background: #17a2b8; }
        .edit { background: #f39c12; }
        .delete { background: #e74c3c; }
        .actions a { text-decoration: none; display: flex; justify-content: center; align-items: center; }
    </style>
</head>

<body>

    <?php include __DIR__ . '/../layouts/header.php'; ?>
    <?php include __DIR__ . '/../layouts/sidebarPaciente.php'; ?>

    <div class="main-content table-container">
        <div class="patients-card">

            <div class="patients-header">
                <h1>Lista de Pacientes</h1>
                <a href="create.php" class="btn-add">
                    <i class="fa-solid fa-user-plus"></i> Nuevo Paciente
                </a>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Correo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($pacientes)): ?>
                        <?php foreach ($pacientes as $paciente): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($paciente['id_paciente']); ?></td>
                                <td><?php echo htmlspecialchars($paciente['nombre_paciente'] . ' ' . $paciente['apellido_paciente']); ?></td>
                                <td><?php echo htmlspecialchars($paciente['telefono_paciente'] ?? 'No registrado'); ?></td>
                                <td><?php echo htmlspecialchars($paciente['correo_paciente'] ?? 'No registrado'); ?></td>
                                <td>
                                    <div class="actions">
                                        <a class="btn-action view" href="show.php?id=<?php echo $paciente['id_paciente']; ?>">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>

                                        <a class="btn-action edit" href="edit.php?id=<?php echo $paciente['id_paciente']; ?>">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>

                                        <form action="../../controllers/PacienteController.php" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este paciente?');">
                                            <input type="hidden" name="accion" value="eliminar">
                                            <input type="hidden" name="id_paciente" value="<?php echo $paciente['id_paciente']; ?>">
                                            <button type="submit" class="btn-action delete">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align: center; color: #777;">No hay pacientes registrados en el sistema.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

        </div>
    </div>

    <?php include __DIR__ . '/../layouts/scriptsPacientes.php'; ?>
</body>

</html>