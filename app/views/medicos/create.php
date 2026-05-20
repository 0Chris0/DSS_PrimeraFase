<?php
session_start();
require_once __DIR__ . '/../../../config/conexion.php';

// Cargar especialidades para el SELECT
try {
    $sqlEspec = "SELECT id_especialidad, nombre_especialidad FROM especialidades ORDER BY nombre_especialidad ASC";
    $stmtEsp = $conexion->prepare($sqlEspec);
    $stmtEsp->execute();
    $especialidades = $stmtEsp->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Procesar Formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] . ' ' . $_POST['apellido']);
    $id_especialidad = $_POST['id_especialidad'];

    if (!empty($nombre) && !empty($id_especialidad)) {
        try {
            $sqlInsert = "INSERT INTO medicos (nombre_medico, id_especialidad) VALUES (:nombre, :id_especialidad)";
            $stmtInsert = $conexion->prepare($sqlInsert);
            $stmtInsert->execute([
                ':nombre' => $nombre,
                ':id_especialidad' => $id_especialidad
            ]);
            echo "<script>alert('Médico registrado exitosamente'); window.location.href='index.php';</script>";
        } catch (PDOException $e) {
            $error = "Error al guardar: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Médico</title>
    <link rel="stylesheet" href="../../../public/css/pacientes.css">
    <link rel="stylesheet" href="../../../public/css/registrospacientes.css">
    <link href="https://fonts.googleapis.com/css2 family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php include __DIR__ . '/../layouts/sidebarPaciente.php'; ?>

<div class="main-content">
    <div class="breadcrumb">
        <span>Inicio</span> / <span>Médicos</span> / <strong>Registrar Médico</strong>
    </div>

    <h1 class="page-title">Registro de Médicos</h1>

    <div class="registro-card">
        <div class="card-header">Completa el formulario para registrar un nuevo médico</div>

        <form class="registro-form" method="POST" action="create.php">
            <div class="form-grid">
                <div class="form-col">
                    <div class="form-group">
                        <label>Nombre</label>
                        <div class="input-icon">
                            <i class="fa-solid fa-user"></i>
                            <input type="text" name="nombre" required placeholder="Ej. Carlos">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Apellido</label>
                        <div class="input-icon">
                            <i class="fa-solid fa-user"></i>
                            <input type="text" name="apellido" required placeholder="Ej. Mendoza">
                        </div>
                    </div>
                </div>

                <div class="form-col right-col">
                    <div class="form-group">
                        <label>Especialidad</label>
                        <div class="input-icon">
                            <i class="fa-solid fa-stethoscope"></i>
                            <select name="id_especialidad" required style="width: 100%; padding: 10px 40px; border-radius: 5px; border: 1px solid #ccc;">
                                <option value="">Seleccione Especialidad</option>
                                <?php foreach ($especialidades as $esp): ?>
                                    <option value="<?= $esp['id_especialidad'] ?>"><?= htmlspecialchars($esp['nombre_especialidad']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="buttons">
                <button class="btn btn-cancel" type="button" onclick="window.location.href='index.php'">
                    <i class="fa-solid fa-xmark"></i> Cancelar
                </button>
                <button class="btn btn-save" type="submit">
                    <i class="fa-solid fa-floppy-disk"></i> Guardar Médico
                </button>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/scriptsPacientes.php'; ?>
</body>
</html>