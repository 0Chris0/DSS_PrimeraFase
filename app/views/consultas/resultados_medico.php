<?php
session_start();
require_once __DIR__ . '/../../../config/conexion.php';

$nombre_buscado = $_GET['nombre_medico'] ?? '';

try {
    // CORREGIDO: Cambiado 'ILIKE' por 'LIKE' para compatibilidad total con MySQL / MariaDB (XAMPP)
    $sql = "SELECT c.id_cita, m.nombre_medico, e.nombre_especialidad, c.fecha_cita, c.estado 
            FROM citas c
            JOIN medicos m ON c.id_medico = m.id_medico
            JOIN especialidades e ON m.id_especialidad = e.id_especialidad
            WHERE m.nombre_medico LIKE :nombre
            ORDER BY c.fecha_cita DESC";
    
    $stmt = $conexion->prepare($sql);
    $stmt->execute(['nombre' => '%' . $nombre_buscado . '%']);
    $citas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al cargar citas: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultados de Búsqueda</title>
    <link rel="stylesheet" href="../../../public/css/pacientes.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .table-container { margin-top: 90px; padding: 25px; }
        .patients-card { background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08); }
        .patients-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .patients-header h1 { color: #0068a5; }
        .btn-add { background: #6c757d; color: white; padding: 10px 15px; border-radius: 7px; text-decoration: none; font-weight: 600; }
        table { width: 100%; border-collapse: collapse; }
        table th { background: #1f57b7; color: white; padding: 14px; }
        table td { padding: 14px; border-bottom: 1px solid #e5e7eb; }
        .actions { display: flex; gap: 10px; }
        .btn-action { width: 35px; height: 35px; border: none; border-radius: 6px; color: white; display: flex; justify-content: center; align-items: center; text-decoration: none; }
        .view { background: #17a2b8; }
        .edit { background: #f39c12; }
        .delete { background: #e74c3c; }
        table th, table td {
            text-align: center; 
            vertical-align: middle; 
            padding: 14px;
            border-bottom: 1px solid #e5e7eb;
        }
    </style>
</head>
<body>

    <?php include __DIR__ . '/../layouts/header.php'; ?>
    <?php include __DIR__ . '/../layouts/sidebarPaciente.php'; ?>

    <div class="main-content table-container">
        <div class="patients-card">
            <div class="patients-header">
                <h1>Citas del <?= htmlspecialchars($nombre_buscado) ?></h1>
                <a href="index.php" class="btn-add"><i class="fa-solid fa-arrow-left"></i> Volver</a>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Médico asignado</th>
                        <th>Especialidad</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($citas)): ?>
                        <?php foreach ($citas as $c): ?>
                            <tr>
                                <td>#<?= $c['id_cita'] ?></td>
                                <td><?= htmlspecialchars($c['nombre_medico']) ?></td>
                                <td><?= htmlspecialchars($c['nombre_especialidad']) ?></td>
                                <td><?= $c['fecha_cita'] ?></td>
                                <td><?= $c['estado'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align: center;">No se encontraron citas para este médico.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include __DIR__ . '/../layouts/scriptsPacientes.php'; ?>
</body>
</html>
