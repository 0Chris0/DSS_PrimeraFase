<?php
session_start();
require_once __DIR__ . '/../../../config/conexion.php';
try {
    $sql = "SELECT m.id_medico, m.nombre_medico, e.nombre_especialidad 
            FROM medicos m
            INNER JOIN especialidades e ON m.id_especialidad = e.id_especialidad
            ORDER BY m.id_medico ASC";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    $medicos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al cargar médicos: " . $e->getMessage());
}
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
        .table-container { margin-top: 90px; padding: 25px; }
        .patients-card { background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08); }
        .patients-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .patients-header h1 { color: #0068a5; }
        .btn-add { background: #1f57b7; color: white; padding: 12px 18px; border-radius: 7px; text-decoration: none; font-weight: 600; }
        table { width: 100%; border-collapse: collapse; }
        table th { background: #1f57b7; color: white; padding: 14px; }
        table td { padding: 14px; border-bottom: 1px solid #e5e7eb; }
        .actions { display: flex; gap: 10px; }
        .btn-action { width: 35px; height: 35px; border: none; border-radius: 6px; color: white; display: flex; justify-content: center; align-items: center; text-decoration: none; }
        .view { background: #17a2b8; }
        .edit { background: #f39c12; }
        .delete { background: #e74c3c; cursor: pointer; }
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
                    <i class="fa-solid fa-user-plus"></i> Nuevo Médico
                </a>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre Completo</th>
                        <th>Especialidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($medicos)): ?>
                        <?php foreach ($medicos as $medico): ?>
                            <tr>
                                <td><?= $medico['id_medico'] ?></td>
                                <td><?= htmlspecialchars($medico['nombre_medico']) ?></td>
                                <td><?= htmlspecialchars($medico['nombre_especialidad']) ?></td>
                                <td>
                                    <div class="actions">
                                        <a href="show.php?id=<?= $medico['id_medico'] ?>" class="btn-action view">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="edit.php?id=<?= $medico['id_medico'] ?>" class="btn-action edit">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                        <form action="index.php" method="POST" style="display:inline;" onsubmit="return confirm('¿Seguro que deseas eliminar este médico?');">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="id_medico" value="<?= $medico['id_medico'] ?>">
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
                            <td colspan="4" style="text-align: center;">No hay médicos registrados en el sistema.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include __DIR__ . '/../layouts/scriptsPacientes.php'; ?>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    try {
        $sqlDelete = "DELETE FROM medicos WHERE id_medico = :id";
        $stmtDel = $conexion->prepare($sqlDelete);
        $stmtDel->execute([':id' => $_POST['id_medico']]);
        echo "<script>window.location.href='index.php';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('No se puede eliminar el médico porque tiene citas agendadas.'); window.location.href='index.php';</script>";
    }
}
?>