<?php
    session_start();
    require_once __DIR__ . '/../../../config/conexion.php';

    $nombre_buscado = trim($_GET['nombre_paciente'] ?? '');

    try {
        // Usamos una lógica de búsqueda más inteligente
        // Si el usuario escribe "Juana Torres", buscamos por "Juana"
        // Usamos 'split' por espacio y tomamos la primera parte para el match inicial
        $partes = explode(' ', $nombre_buscado);
        $nombre_a_buscar = $partes[0]; 

        // CORREGIDO: Cambiado 'ILIKE' por 'LIKE' para compatibilidad total con MySQL / MariaDB (XAMPP)
        $sql = "SELECT c.id_cita, p.nombre_paciente, e.nombre_especialidad, m.nombre_medico, c.fecha_cita, c.estado 
                FROM citas c
                INNER JOIN pacientes p ON c.id_paciente = p.id_paciente
                INNER JOIN medicos m ON c.id_medico = m.id_medico
                INNER JOIN especialidades e ON m.id_especialidad = e.id_especialidad
                WHERE p.nombre_paciente LIKE :nombre
                ORDER BY c.fecha_cita DESC";
        
        $stmt = $conexion->prepare($sql);
        // Buscamos coincidencia con la primera parte del nombre
        $stmt->execute(['nombre' => '%' . $nombre_a_buscar . '%']);
        $historial = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($historial)) {
            // Si no encuentra nada, damos una salida amigable en lugar de un error técnico
            $mensaje_error = "No se encontraron citas para: " . htmlspecialchars($nombre_buscado);
        }

    } catch (PDOException $e) {
        die("Error en la consulta: " . $e->getMessage());
    }
    ?>

    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Historial del Paciente</title>
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
                    <h1>Historial: <?= htmlspecialchars($nombre_buscado) ?></h1>
                    <a href="index.php" class="btn-regresar"><i class="fa-solid fa-arrow-left"></i> Volver</a>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>ID Cita</th>
                            <th>Médico</th>
                            <th>Especialidad</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($historial)): ?>
                            <?php foreach ($historial as $c): ?>
                                <tr>
                                    <td>#<?= $c['id_cita'] ?></td>
                                    <td><?= htmlspecialchars($c['nombre_medico']) ?></td>
                                    <td><?= htmlspecialchars($c['nombre_especialidad']) ?></td>
                                    <td><?= $c['fecha_cita'] ?></td>
                                    <td><?= $c['estado'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="5"><?= isset($mensaje_error) ? $mensaje_error : 'No se encontró historial para este paciente.' ?></td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
    </html>
