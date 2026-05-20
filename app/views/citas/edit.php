<?php 
session_start(); 
require_once __DIR__ . '/../../controllers/CitasController.php';

$controller = new CitasController();

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$cita = $controller->obtenerPorId($_GET['id']);
$medicos = $controller->obtenerMedicos();

// Procesar la edición
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_cita = $_POST['id_cita'];
    $id_medico = $_POST['id_medico'];
    $fecha_cita = $_POST['fecha_cita'];

    if (!empty($id_medico) && !empty($fecha_cita)) {
        // CORREGIDO: Le pasamos el $cita['id_paciente'] como cuarto parámetro para que no se borre en MySQL
        $controller->actualizarCita($id_cita, $id_medico, $fecha_cita, $cita['id_paciente']);
        header("Location: index.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cita</title>
    <link rel="stylesheet" href="../../../public/css/editarcita.css">
    <link rel="stylesheet" href="../../../public/css/pacientes.css">
    <link rel="stylesheet" href="../../../public/css/registrospacientes.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

    <?php include __DIR__ . '/../layouts/header.php'; ?>
    <?php include __DIR__ . '/../layouts/sidebarPaciente.php'; ?>

    <div class="main-content">
        <div class="breadcrumb">
            Inicio / Citas / <strong>Editar Cita</strong>
        </div>

        <h1 class="page-title">Editar Cita</h1>

        <div class="card">
            <div class="card-header">
                Modificar información de la cita #<?= $cita['id_cita'] ?>
            </div>

            <form class="form-grid" method="POST" action="edit.php?id=<?= $cita['id_cita'] ?>">
                <input type="hidden" name="id_cita" value="<?= $cita['id_cita'] ?>">

                <div class="form-group">
                    <label>Fecha de la Cita</label>
                    <input type="date" name="fecha_cita" value="<?= $cita['fecha_cita'] ?>" required>
                </div>

                <div class="form-group">
                    <label>Asignar Médico Experto</label>
                    <select name="id_medico" required style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #cbd5e1; height: 45px;">
                        <?php foreach ($medicos as $medico): ?>
                            <option value="<?= $medico['id_medico'] ?>" <?= $medico['id_medico'] == $cita['id_medico'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($medico['nombre_medico']) ?> (<?= htmlspecialchars($medico['nombre_especialidad']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group full">
                    <label>Motivo de Consulta</label>
                    <textarea>Revisión periódica y ajuste de tratamiento.</textarea>
                </div>

                <div class="buttons">
                    <button class="btn-cancel" type="button" onclick="window.location.href='index.php'">
                        <i class="fa-solid fa-xmark"></i> Cancelar
                    </button>
                    <button class="btn-save" type="submit">
                        <i class="fa-solid fa-floppy-disk"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>

    <?php include __DIR__ . '/../layouts/scriptsPacientes.php'; ?>
</body>
</html>