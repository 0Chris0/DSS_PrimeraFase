<?php 
session_start(); 
require_once __DIR__ . '/../../controllers/CitasController.php';

$controller = new CitasController();
$medicos = $controller->obtenerMedicos();
// 1. Cargamos los pacientes existentes desde la base de datos
$pacientes = $controller->obtenerPacientes();

// Procesar Formulario de inserción
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_paciente = $_POST['id_paciente'] ?? null;
    $id_medico = $_POST['id_medico'] ?? null;
    $fecha_cita = $_POST['fecha_cita'] ?? null;
    $motivo_consulta = $_POST['motivo_consulta'] ?? '';
    // AGREGADO: Captura de la hora seleccionada
    $hora_cita = !empty($_POST['hora_cita']) ? $_POST['hora_cita'] : null; 

    // Validamos que los tres parámetros obligatorios contengan datos
    if (!empty($id_paciente) && !empty($id_medico) && !empty($fecha_cita)) {
        try {
            // CORREGIDO PARA TU CONTROLADOR: Enviamos primero el motivo de consulta, luego la hora de la cita
            $controller->guardarCita($id_paciente, $id_medico, $fecha_cita, $motivo_consulta, $hora_cita);
            $_SESSION['success'] = "Cita programada exitosamente.";
            header("Location: index.php");
            exit();
        } catch (Exception $e) {
            $error_mensaje = $e->getMessage();
        }
    } else {
        $error_mensaje = "Por favor, complete todos los campos obligatorios.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programar Cita</title>
    <link rel="stylesheet" href="../../../public/css/programarcita.css">
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
            <span>Inicio</span> / <span>Citas</span> / <strong>Programar Cita</strong>
        </div>

        <h1 class="page-title">Programar Cita</h1>

        <?php if (isset($error_mensaje)): ?>
            <div style="background-color: #f8d7da; color: #721c24; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-family: 'Poppins'; border: 1px solid #f5c6cb;">
                <i class="fa-solid fa-triangle-exclamation"></i> <?= htmlspecialchars($error_mensaje) ?>
            </div>
        <?php endif; ?>

        <div class="registro-card">
            <div class="card-header">
                Completa el formulario para registrar una nueva cita en la base de datos
            </div>

            <form class="registro-form" method="POST" action="create.php">
                <div class="form-grid">
                    
                    <div class="form-col">
                        <div class="form-group">
                            <label>Fecha de la Cita</label>
                            <div class="input-icon" style="cursor: pointer;" onclick="document.getElementById('fechaInput').showPicker();">
                                <i class="fa-regular fa-calendar"></i>
                                <input type="date" name="fecha_cita" id="fechaInput" required style="cursor: pointer;">
                            </div>
                        </div>

                        <div class="calendar-box">
                            <div class="calendar-header">Mayo 2026</div>
                            <div class="calendar-grid">
                                <div class="day-name">Do</div><div class="day-name">Lu</div><div class="day-name">Ma</div><div class="day-name">Mi</div><div class="day-name">Ju</div><div class="day-name">Vi</div><div class="day-name">Sa</div>
                                
                                <?php for($i=1; $i<=31; $i++): ?>
                                    <div onclick="seleccionarFecha(<?= $i ?>, this)"><?= $i ?></div>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-col">
                        <div class="form-group">
                            <label>Seleccionar Paciente</label>
                            <div class="input-icon" style="display:block;">
                                <select name="id_paciente" required style="width: 100%; padding: 12px 35px; border-radius: 10px; border: 1px solid #cbd5e1; font-family: 'Poppins';">
                                    <option value="">-- Seleccione un paciente --</option>
                                    <?php foreach ($pacientes as $pac): ?>
                                        <option value="<?= $pac['id_paciente'] ?>">
                                            <?= htmlspecialchars($pac['nombre_paciente'] . ' ' . $pac['apellido_paciente']) ?> (ID: <?= htmlspecialchars($pac['numero_identificacion']) ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Seleccionar Médico y Especialidad</label>
                            <div class="input-icon" style="display:block;">
                                <select name="id_medico" required style="width: 100%; padding: 12px 35px; border-radius: 10px; border: 1px solid #cbd5e1; font-family: 'Poppins';">
                                    <option value="">-- Seleccione un especialista --</option>
                                    <?php foreach ($medicos as $medico): ?>
                                        <option value="<?= $medico['id_medico'] ?>">
                                            <?= htmlspecialchars($medico['nombre_medico']) ?> (<?= htmlspecialchars($medico['nombre_especialidad']) ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- AGREGADO: Campo de selección de Hora -->
                        <div class="form-group">
                            <label>Hora de la Cita</label>
                            <div class="input-icon" style="cursor: pointer;" onclick="document.getElementById('horaInput').showPicker();">
                                <i class="fa-regular fa-clock" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #64748b;"></i>
                                <input type="time" name="hora_cita" id="horaInput" required style="width: 100%; padding: 12px 12px 12px 35px; border-radius: 10px; border: 1px solid #cbd5e1; font-family: 'Poppins'; cursor: pointer;">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Motivo de la Consulta</label>
                            <div class="motivo-box">
                                <i class="fa-solid fa-pencil"></i>
                                <textarea name="motivo_consulta" placeholder="Escribe el motivo aquí..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="buttons">
                    <button class="btn-cancel" type="button" onclick="window.location.href='index.php'">
                        <i class="fa-solid fa-xmark"></i> Cancelar
                    </button>
                    <button class="btn-save" type="submit">
                        <i class="fa-regular fa-calendar-check"></i> Programar Cita
                    </button>
                </div>
            </form>
        </div>
    </div>

    <?php include __DIR__ . '/../layouts/scriptsPacientes.php'; ?>

    <script>
function seleccionarFecha(dia, elemento){
    document.querySelectorAll('.calendar-grid div').forEach(el => el.classList.remove('active-day'));
    elemento.classList.add('active-day'); 
    
    const fecha = `2026-05-${String(dia).padStart(2,'0')}`;
    document.getElementById('fechaInput').value = fecha;
}
</script>
</body>
</html>
