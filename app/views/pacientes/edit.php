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
    <title>Editar Paciente</title>
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
        <span>Inicio</span> / <span>Pacientes</span> / <strong>Editar Paciente</strong>
    </div>

    <h1 class="page-title">Editar Paciente</h1>

    <div class="registro-card">
        <div class="card-header">
            Modifica la información del paciente
        </div>

        <form class="registro-form" action="../../controllers/PacienteController.php" method="POST">
            
            <input type="hidden" name="accion" value="actualizar">
            <input type="hidden" name="id_paciente" value="<?php echo htmlspecialchars($paciente['id_paciente'] ?? ''); ?>">
            <input type="hidden" name="numero_identificacion" value="<?php echo htmlspecialchars($paciente['numero_identificacion'] ?? ''); ?>">

            <div class="form-grid">

                <div class="form-col">
                    <div class="form-group">
                        <label>Nombre</label>
                        <div class="input-icon">
                            <i class="fa-solid fa-user"></i>
                            <input type="text" name="nombre" value="<?php echo htmlspecialchars($paciente['nombre_paciente'] ?? ''); ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Apellido</label>
                        <div class="input-icon">
                            <i class="fa-solid fa-user"></i>
                            <input type="text" name="apellido" value="<?php echo htmlspecialchars($paciente['apellido_paciente'] ?? ''); ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Teléfono</label>
                        <div class="input-icon">
                            <i class="fa-solid fa-phone"></i>
                            <input type="text" name="telefono" value="<?php echo htmlspecialchars($paciente['telefono_paciente'] ?? ''); ?>" required>
                        </div>
                    </div>
                </div>

                <div class="form-col right-col">
                    <div class="form-group">
                        <label>Correo</label>
                        <div class="input-icon">
                            <i class="fa-solid fa-envelope"></i>
                            <input type="email" name="correo" value="<?php echo htmlspecialchars($paciente['correo_paciente'] ?? ''); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Sexo</label>
                        <div class="input-icon">
                            <i class="fa-solid fa-user"></i>
                            <select name="genero">
                                <option value="Femenino" <?php echo (($paciente['genero'] ?? '') == 'Femenino') ? 'selected' : ''; ?>>Femenino</option>
                                <option value="Masculino" <?php echo (($paciente['genero'] ?? '') == 'Masculino') ? 'selected' : ''; ?>>Masculino</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Dirección</label>
                        <div class="input-icon">
                            <i class="fa-solid fa-location-dot"></i>
                            <input type="text" name="direccion" value="<?php echo htmlspecialchars($paciente['direccion'] ?? ''); ?>">
                        </div>
                    </div>
                </div>

            </div>

            <div class="buttons">
                <button class="btn btn-cancel" type="button" onclick="window.location.href='index.php'">
                    <i class="fa-solid fa-xmark"></i> Cancelar
                </button>

                <button class="btn btn-save" type="submit">
                    <i class="fa-solid fa-pen"></i> Actualizar
                </button>
            </div>

        </form>
    </div>

</div>

<?php include __DIR__ . '/../layouts/scriptsPacientes.php'; ?>
</body>
</html>