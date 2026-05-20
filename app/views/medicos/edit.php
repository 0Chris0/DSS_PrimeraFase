<?php
session_start();
require_once __DIR__ . '/../../../config/conexion.php';

$id = $_GET['id'] ?? null;
if (!$id) { header('Location: index.php'); exit; }

try {
    // Obtener datos del médico actual
    $sqlMedico = "SELECT * FROM medicos WHERE id_medico = :id";
    $stmtM = $conexion->prepare($sqlMedico);
    $stmtM->execute([':id' => $id]);
    $medico = $stmtM->fetch(PDO::FETCH_ASSOC);

    // Obtener especialidades para el select
    $sqlEsp = "SELECT id_especialidad, nombre_especialidad FROM especialidades";
    $stmtE = $conexion->prepare($sqlEsp);
    $stmtE->execute();
    $especialidades = $stmtE->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre_medico']);
    $id_especialidad = $_POST['id_especialidad'];

    try {
        $sqlUpdate = "UPDATE medicos SET nombre_medico = :nombre, id_especialidad = :id_esp WHERE id_medico = :id";
        $stmtUp = $conexion->prepare($sqlUpdate);
        $stmtUp->execute([
            ':nombre' => $nombre,
            ':id_esp' => $id_especialidad,
            ':id' => $id
        ]);
        echo "<script>alert('Médico actualizado'); window.location.href='index.php';</script>";
    } catch (PDOException $e) {
        die("Error al actualizar: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Médico</title>
    <link rel="stylesheet" href="../../../public/css/pacientes.css">
    <link rel="stylesheet" href="../../../public/css/registrospacientes.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

    <?php include __DIR__ . '/../layouts/header.php'; ?>
    <?php include __DIR__ . '/../layouts/sidebarPaciente.php'; ?>

    <div class="main-content">
        <h1 class="page-title">Editar Médico</h1>

        <div class="registro-card">
            <div class="card-header">Modificar información del médico</div>

            <form class="registro-form" method="POST">
                <div class="form-grid">
                    <div class="form-col">
                        <div class="form-group">
                            <label>Nombre Médico</label>
                            <div class="input-icon">
                                <i class="fa-solid fa-user"></i>
                                <input type="text" name="nombre_medico" value="<?= htmlspecialchars($medico['nombre_medico']) ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-col right-col">
                        <div class="form-group">
                            <label>Especialidad</label>
                            <div class="input-icon">
                                <i class="fa-solid fa-stethoscope"></i>
                                <select name="id_especialidad" required style="width:100%; padding: 10px 40px;">
                                    <?php foreach ($especialidades as $esp): ?>
                                        <option value="<?= $esp['id_especialidad'] ?>" <?= $esp['id_especialidad'] == $medico['id_especialidad'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($esp['nombre_especialidad']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="buttons">
                    <button type="button" class="btn btn-cancel" onclick="window.location.href='index.php'">Cancelar</button>
                    <button type="submit" class="btn btn-save">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
    <?php include __DIR__ . '/../layouts/scriptsPacientes.php'; ?>
</body>
</html>