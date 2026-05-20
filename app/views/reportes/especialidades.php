<?php 
session_start(); 

require_once __DIR__ . '/../../../config/conexion.php';

try {
    $sql = "SELECT 
                e.nombre_especialidad AS especialidad,
                COUNT(c.id_cita) AS total_consultas,
                COUNT(DISTINCT m.id_medico) AS total_medicos
            FROM especialidades e
            LEFT JOIN medicos m ON e.id_especialidad = m.id_especialidad
            LEFT JOIN citas c ON m.id_medico = c.id_medico
            GROUP BY e.id_especialidad, e.nombre_especialidad
            ORDER BY total_consultas DESC";

    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    $reporte = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Error al cargar el reporte: " . $e->getMessage());
}
?>

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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
                    <?php if (!empty($reporte)): ?>
                        <?php foreach ($reporte as $fila): ?>
                            <tr>
                                <td><?= htmlspecialchars($fila['especialidad']) ?></td>
                                <td><?= $fila['total_consultas'] ?></td>
                                <td><?= $fila['total_medicos'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" style="text-align: center;">No hay datos en la base de datos.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>

    <?php include __DIR__ . '/../layouts/scriptsPacientes.php'; ?>
</body>

</html>