<?php
session_start();
require_once __DIR__ . '/../../../config/conexion.php';

$nombre_buscado = trim($_GET['nombre_paciente'] ?? '');

try {
    // CORREGIDO: Cambiado 'ILIKE' por 'LIKE' y optimizada la validación de texto vacío para MySQL
    $sql = "SELECT c.id_cita, 
                   COALESCE(p.nombre_paciente, 'Sin Paciente') as nombre_paciente, 
                   m.nombre_medico, 
                   e.nombre_especialidad, 
                   c.fecha_cita, 
                   c.estado 
            FROM citas c
            LEFT JOIN pacientes p ON c.id_paciente = p.id_paciente
            LEFT JOIN medicos m ON c.id_medico = m.id_medico
            LEFT JOIN especialidades e ON m.id_especialidad = e.id_especialidad
            WHERE (p.nombre_paciente LIKE :nombre OR :nombre_vacio = '')
            ORDER BY c.fecha_cita DESC";
    
    $stmt = $conexion->prepare($sql);
    
    // Si el nombre tiene varias palabras, tomamos la primera para asegurar el 'match'
    $partes = explode(' ', $nombre_buscado);
    $primer_nombre = $partes[0];
    $busqueda = '%' . $primer_nombre . '%'; 

    $stmt->execute([
        ':nombre'       => $busqueda,
        ':nombre_vacio' => $primer_nombre
    ]);
    $citas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Si sigue vacío, verificamos si es que NO HAY CITAS en general
    if (empty($citas)) {
        echo "<h3>No se encontraron citas.</h3>";
        echo "<a href='index.php'>Volver</a>";
        exit;
    }

} catch (PDOException $e) {
    die("Error en base de datos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultados de Citas</title>
    <link rel="stylesheet" href="../../../public/css/pacientes.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .table-container { margin-top: 90px; padding: 25px; }
        .patients-card { background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08); }
        .patients-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; text-align: center; }
        table th { background: #1f57b7; color: white; padding: 14px; }
        table td { padding: 14px; border-bottom: 1px solid #e5e7eb; }
        .btn-regresar { background: #6c757d; color: white; padding: 10px 15px; border-radius: 7px; text-decoration: none; }
    </style>
</head>
<body>
    <?php include __DIR__ . '/../layouts/header.php'; ?>
    <?php include __DIR__ . '/../layouts/sidebarPaciente.php'; ?>

    <div class="main-content table-container">
        <div class="patients-card">
            <div class="patients-header">
                <h1>Citas encontradas para <?= htmlspecialchars($nombre_buscado) ?></h1>
                <a href="index.php" class="btn-regresar"><i class="fa-solid fa-arrow-left"></i> Volver</a>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>ID Cita</th>
                        <th>Paciente</th>
                        <th>Médico</th>
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
                                <td><?= htmlspecialchars($c['nombre_paciente']) ?></td>
                                <td><?= htmlspecialchars($c['nombre_medico']) ?></td>
                                <td><?= htmlspecialchars($c['nombre_especialidad']) ?></td>
                                <td><?= $c['fecha_cita'] ?></td>
                                <td><?= $c['estado'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6">No se encontraron citas para este paciente.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
