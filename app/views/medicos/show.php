<?php
session_start();
require_once __DIR__ . '/../../../config/conexion.php';

$id = $_GET['id'] ?? null;
if (!$id) { header('Location: index.php'); exit; }

try {
    $sql = "SELECT m.id_medico, m.nombre_medico, e.nombre_especialidad 
            FROM medicos m
            INNER JOIN especialidades e ON m.id_especialidad = e.id_especialidad
            WHERE m.id_medico = :id";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([':id' => $id]);
    $medico = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle Médico</title>
    <link rel="stylesheet" href="../../../public/css/pacientes.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .detail-container { margin-top: 90px; padding: 25px; }
        .detail-card { background: white; border-radius: 10px; padding: 35px; max-width: 850px; margin: auto; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08); }
        .detail-title { color: #0068a5; margin-bottom: 30px; }
        .detail-grid { display: grid; grid-template-columns: 1fr; gap: 25px; }
        .detail-item { background: #f5f7fb; padding: 18px; border-radius: 8px; }
        .detail-item span { display: block; font-size: 13px; color: #64748b; margin-bottom: 5px; }
        .detail-item strong { font-size: 16px; color: #0f172a; }
        .btn-back { display: inline-block; margin-top: 20px; background: #1f57b7; color: white; padding: 10px 15px; border-radius: 5px; text-decoration: none; font-weight: 500; }
    </style>
</head>
<body>

    <?php include __DIR__ . '/../layouts/header.php'; ?>
    <?php include __DIR__ . '/../layouts/sidebarPaciente.php'; ?>

    <div class="main-content detail-container">
        <div class="detail-card">
            <h1 class="detail-title">Información del Médico</h1>

            <div class="detail-grid">
                <div class="detail-item">
                    <span>ID Médico</span>
                    <strong># <?= $medico['id_medico'] ?></strong>
                </div>
                <div class="detail-item">
                    <span>Nombre Completo</span>
                    <strong><?= htmlspecialchars($medico['nombre_medico']) ?></strong>
                </div>
                <div class="detail-item">
                    <span>Especialidad Asignada</span>
                    <strong><?= htmlspecialchars($medico['nombre_especialidad']) ?></strong>
                </div>
            </div>
            
            <a href="index.php" class="btn-back"><i class="fa-solid fa-arrow-left"></i> Volver a la lista</a>
        </div>
    </div>

    <?php include __DIR__ . '/../layouts/scriptsPacientes.php'; ?>
</body>
</html>