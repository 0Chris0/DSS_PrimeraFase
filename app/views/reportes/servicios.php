<?php
session_start();
// CORREGIDO: Cambiamos $user a 'root' y actualizamos los puertos/credenciales para MySQL
$host = "localhost"; 
$port = "3306"; 
$dbname = "clinica"; 
$user = "root"; // <- Cambio clave aquí
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta que une todo: Especialidad -> Médico -> Citas
    $sql = "SELECT e.nombre_especialidad, COUNT(c.id_cita) as total 
            FROM especialidades e
            LEFT JOIN medicos m ON e.id_especialidad = m.id_especialidad
            LEFT JOIN citas c ON m.id_medico = c.id_medico
            GROUP BY e.nombre_especialidad
            ORDER BY total DESC";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $servicios = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Error en la BD: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Servicios Más Solicitados</title>
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
        <div class="breadcrumb">Inicio / Reportes / <strong>Servicios Más Solicitados</strong></div>
        <h1 class="page-title">Servicios Más Solicitados</h1>

        <div class="stats-grid">
            <?php if (!empty($servicios)): ?>
                <?php foreach ($servicios as $s): ?>
                    <div class="stat-card">
                        <i class="fa-solid fa-briefcase"></i>
                        <h3><?= htmlspecialchars($s['nombre_especialidad']); ?></h3>
                        <p><?= htmlspecialchars($s['total']); ?> solicitudes</p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No se encontraron servicios registrados.</p>
            <?php endif; ?>
        </div>
    </div>
    <?php include __DIR__ . '/../layouts/scriptsPacientes.php'; ?>
</body>
</html>