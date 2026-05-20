<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['id'])) {
    $_GET['accion'] = 'obtener';
    
    require_once '../../controllers/PacienteController.php';
    
    $paciente = $_SESSION['paciente'] ?? null;
    unset($_SESSION['paciente']);
}

if (!$paciente) {
    echo "Paciente no encontrado.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Paciente</title>
    <link rel="stylesheet" href="../../../public/css/pacientes.css">
    <link rel="stylesheet" href="../../../public/css/registrospacientes.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>

    <?php include __DIR__ . '/../layouts/header.php'; ?>
    <?php include __DIR__ . '/../layouts/sidebarPaciente.php'; ?>

    <div class="main-content">

        <div class="breadcrumb">
            <span>Inicio</span> / <span>Pacientes</span> / <strong>Ver Detalles</strong>
        </div>

        <h1 class="page-title">Información del Paciente</h1>

        <div class="registro-card">
            <div class="card-header">
                Datos generales registrados
            </div>

            <div class="registro-form">
                <div class="form-grid">

                    <div class="form-col">
                        <div class="form-group">
                            <label>ID Paciente</label>
                            <div class="input-icon">
                                <i class="fa-solid fa-key"></i>
                                <input type="text" value="<?php echo htmlspecialchars($paciente['id_paciente'] ?? ''); ?>" disabled>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Nombre Completo</label>
                            <div class="input-icon">
                                <i class="fa-solid fa-user"></i>
                                <input type="text" value="<?php echo htmlspecialchars(($paciente['nombre_paciente'] ?? '') . ' ' . ($paciente['apellido_paciente'] ?? '')); ?>" disabled>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Número de Identificación</label>
                            <div class="input-icon">
                                <i class="fa-solid fa-id-card"></i>
                                <input type="text" value="<?php echo htmlspecialchars($paciente['numero_identificacion'] ?? ''); ?>" disabled>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Teléfono</label>
                            <div class="input-icon">
                                <i class="fa-solid fa-phone"></i>
                                <input type="text" value="<?php echo htmlspecialchars($paciente['telefono_paciente'] ?? 'No registrado'); ?>" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="form-col right-col">
                        <div class="form-group">
                            <label>Correo Electrónico</label>
                            <div class="input-icon">
                                <i class="fa-solid fa-envelope"></i>
                                <input type="text" value="<?php echo htmlspecialchars($paciente['correo_paciente'] ?? 'No registrado'); ?>" disabled>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Género</label>
                            <div class="input-icon">
                                <i class="fa-solid fa-venus-mars"></i>
                                <input type="text" value="<?php echo htmlspecialchars($paciente['genero'] ?? 'No especificado'); ?>" disabled>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Fecha de Nacimiento</label>
                            <div class="input-icon">
                                <i class="fa-solid fa-calendar-days"></i>
                                <input type="text" value="<?php echo htmlspecialchars($paciente['fecha_nacimiento'] ?? 'No registrada'); ?>" disabled>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Dirección</label>
                            <div class="input-icon">
                                <i class="fa-solid fa-location-dot"></i>
                                <input type="text" value="<?php echo htmlspecialchars($paciente['direccion'] ?? 'No registrada'); ?>" disabled>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="buttons" style="justify-content: flex-end;">
                    <button class="btn btn-cancel" type="button" onclick="window.location.href='index.php'" style="background: #6c757d;">
                        <i class="fa-solid fa-arrow-left"></i> Volver al listado
                    </button>
                    <button class="btn btn-save" type="button" onclick="window.location.href='edit.php?id=<?php echo $paciente['id_paciente']; ?>'">
                        <i class="fa-solid fa-pen"></i> Editar Paciente
                    </button>
                </div>
            </div>

        </div>
    </div>

    <?php include __DIR__ . '/../layouts/scriptsPacientes.php'; ?>
</body>

</html>