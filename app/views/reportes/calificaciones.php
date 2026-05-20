<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION['rol'])) {
    header("Location: ../auth/login.php");
    exit();
}

// CORREGIDO: Credenciales correctas para MySQL en XAMPP
$host     = "localhost";
$port     = "3306";
$dbname   = "clinica";
$user     = "root";
$password = ""; 

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $sql = "SELECT 
                m.nombre_medico AS medico,
                IFNULL(AVG(c.puntuacion), 0) AS calificacion, 
                IFNULL(GROUP_CONCAT(c.comentario SEPARATOR ' | '), 'Sin comentarios') AS comentario
            FROM medicos m
            LEFT JOIN consultas con ON m.id_medico = con.id_medico
            LEFT JOIN calificaciones c ON con.id_consulta = c.id_consulta
            GROUP BY m.id_medico, m.nombre_medico
            ORDER BY m.nombre_medico ASC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $calificaciones = $stmt->fetchAll();

} catch (PDOException $e) {
    $calificaciones = [];
    error_log("Error en calificaciones: " . $e->getMessage());
    $error_msg = "Error al cargar las calificaciones: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calificaciones</title>
    <link rel="stylesheet" href="../../../public/css/reportesPages.css">
    <link rel="stylesheet" href="../../../public/css/registrospacientes.css">
    <link rel="stylesheet" href="../../../public/css/pacientes.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        .star-gold {
            color: #f59e0b;
            margin-right: 2px;
        }
        .star-empty {
            color: #cbd5e1;
            margin-right: 2px;
        }
    </style>
</head>

<body>

    <?php include __DIR__ . '/../layouts/header.php'; ?>
    <?php include __DIR__ . '/../layouts/sidebarPaciente.php'; ?>

    <div class="main-content">

        <div class="breadcrumb">
            Inicio / Reportes / <strong>Calificaciones</strong>
        </div>

        <h1 class="page-title">Calificaciones de Servicio</h1>

        <?php if (isset($error_msg) && empty($calificaciones)): ?>
            <div style="background-color: #fee2e2; color: #991b1b; padding: 12px; border-radius: 8px; margin-bottom: 15px; font-size: 14px;">
                <i class="fa-solid fa-triangle-exclamation"></i> <?= htmlspecialchars($error_msg); ?>
            </div>
        <?php endif; ?>

        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>Médico</th>
                        <th>Calificación</th>
                        <th>Comentario</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($calificaciones) > 0): ?>
                        <?php foreach ($calificaciones as $row): ?>
                            <tr>
                                <td>
                                    <i class="fa-solid fa-user-doctor" style="color: #3b82f6; margin-right: 8px;"></i>
                                    Dr(a). <?= htmlspecialchars($row['medico']); ?>
                                </td>
                                <td>
                                    <?php 
                                    $estrellasActivas = (int)$row['calificacion'];
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($i <= $estrellasActivas) {
                                            echo '<i class="fa-solid fa-star star-gold"></i>';
                                        } else {
                                            echo '<i class="fa-regular fa-star star-empty"></i>';
                                        }
                                    }
                                    ?>
                                </td>
                                <td>
                                    <em style="color: #475569;">"<?= htmlspecialchars($row['comentario']); ?>"</em>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" style="text-align: center; color: #94a3b8; padding: 30px;">
                                <i class="fa-solid fa-star-half-stroke" style="font-size: 24px; display: block; margin-bottom: 10px;"></i>
                                Aún no se han registrado calificaciones para los servicios médicos.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include __DIR__ . '/../layouts/scriptsPacientes.php'; ?>
</body>
</html>