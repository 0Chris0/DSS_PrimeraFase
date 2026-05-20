<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);
session_start();

if (!isset($_SESSION['rol'])) {
    header("Location: ../auth/login.php");
    exit();
}

$host     = "localhost";
$port     = "3306";
$dbname   = "clinica";
$user     = "root";
$password = ""; 

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // SOLUCIÓN REAL: Iniciamos desde CITAS para obtener datos 100% verídicos.
    // Cruzamos con consultas para traer el diagnóstico si ya existe, de lo contrario muestra el motivo original de la cita.
    $sql = "SELECT 
                c.id_cita,
                CONCAT(p.nombre_paciente, ' ', p.apellido_paciente) AS paciente,
                m.nombre_medico AS medico,
                DATE_FORMAT(c.fecha_cita, '%d/%m/%Y') AS fecha,
                IFNULL(con.diagnóstico, CONCAT('Pendiente (Motivo: ', IFNULL(c.motivo_cita, 'Consulta general'), ')')) AS diagnostico 
            FROM citas c
            INNER JOIN pacientes p ON c.id_paciente = p.id_paciente
            INNER JOIN medicos m ON c.id_medico = m.id_medico
            LEFT JOIN consultas con ON c.id_paciente = con.id_paciente AND c.id_medico = con.id_medico
            ORDER BY c.fecha_cita DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $historial = $stmt->fetchAll();

} catch (PDOException $e) {
    $historial = [];
    $error_msg = "Error al conectar con el historial clínico: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Atención</title>
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

        <div class="breadcrumb">
            Inicio / Reportes / <strong>Historial de Atención</strong>
        </div>

        <h1 class="page-title">Historial de Atención</h1>

        <?php if (isset($error_msg)): ?>
            <div style="background-color: #fee2e2; color: #991b1b; padding: 12px; border-radius: 8px; margin-bottom: 15px; font-size: 14px;">
                <i class="fa-solid fa-triangle-exclamation"></i> <?= htmlspecialchars($error_msg); ?>
            </div>
        <?php endif; ?>

        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>Paciente</th>
                        <th>Médico</th>
                        <th>Fecha</th>
                        <th>Diagnóstico</th>
                        <th>Acción</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($historial) > 0): ?>
                        <?php foreach ($historial as $row): ?>
                            <tr>
                                <td>
                                    <i class="fa-solid fa-user-injured" style="color: #10b981; margin-right: 8px;"></i>
                                    <?= htmlspecialchars($row['paciente']); ?>
                                </td>
                                <td>
                                    <i class="fa-solid fa-user-doctor" style="color: #3b82f6; margin-right: 8px;"></i>
                                    Dr(a). <?= htmlspecialchars($row['medico']); ?>
                                </td>
                                <td>
                                    <i class="fa-solid fa-calendar-day" style="color: #64748b; margin-right: 8px;"></i>
                                    <?= htmlspecialchars($row['fecha']); ?>
                                </td>
                                <td>
                                    <span style="background-color: #f1f5f9; padding: 4px 8px; border-radius: 6px; font-size: 13px; color: #334155;">
                                        <?= htmlspecialchars($row['diagnostico']); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if (!empty($row['id_cita'])): ?>
                                        <button type="button" 
                                                onclick="abrirModalCalificar(<?= (int)$row['id_cita']; ?>, '<?= htmlspecialchars($row['medico']); ?>')" 
                                                style="background-color: #2563eb; color: #ffffff; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-family: 'Poppins', sans-serif; font-size: 12px; font-weight: 500; display: inline-flex; align-items: center; gap: 6px;">
                                            <i class="fa-solid fa-star" style="color: #f59e0b;"></i> Calificar
                                        </button>
                                    <?php else: ?>
                                        <span style="color: #94a3b8; font-size: 12px; font-style: italic;">No vinculada</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align: center; color: #94a3b8; padding: 30px;">
                                <i class="fa-solid fa-folder-open" style="font-size: 24px; display: block; margin-bottom: 10px;"></i>
                                No se encontraron registros de atención en el historial médico.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div id="modalCalificar" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); align-items: center; justify-content: center;">
        <div style="background-color: #ffffff; padding: 25px; border-radius: 12px; width: 100%; max-width: 450px; box-shadow: 0 4px 20px rgba(0,0,0,0.15); font-family: 'Poppins', sans-serif;">
            <h3 style="margin-top: 0; color: #1e293b; font-size: 18px;"><i class="fa-solid fa-star-half-stroke" style="color: #f59e0b;"></i> Calificar Servicio Médico</h3>
            <p style="font-size: 14px; color: #64748b; margin-bottom: 20px;">Evalúa tu atención con el/la <strong id="modalNombreMedico">Médico</strong></p>
            
            <form id="formCalificarCita">
                <input type="hidden" id="modalIdCita" name="id_cita">
                <input type="hidden" id="inputValorCalificacion" name="calificacion" value="0">
                
                <div style="text-align: center; margin-bottom: 20px;">
                    <label style="display: block; font-size: 13px; font-weight: 500; color: #475569; margin-bottom: 8px;">Selecciona las estrellas:</label>
                    <div id="starRatingContainer" style="font-size: 28px; cursor: pointer;">
                        <i class="fa-regular fa-star star-input" data-value="1" style="color: #cbd5e1; transition: color 0.2s;"></i>
                        <i class="fa-regular fa-star star-input" data-value="2" style="color: #cbd5e1; transition: color 0.2s;"></i>
                        <i class="fa-regular fa-star star-input" data-value="3" style="color: #cbd5e1; transition: color 0.2s;"></i>
                        <i class="fa-regular fa-star star-input" data-value="4" style="color: #cbd5e1; transition: color 0.2s;"></i>
                        <i class="fa-regular fa-star star-input" data-value="5" style="color: #cbd5e1; transition: color 0.2s;"></i>
                    </div>
                </div>

                <div style="margin-bottom: 20px;">
                    <label for="modalComentario" style="display: block; font-size: 13px; font-weight: 500; color: #475569; margin-bottom: 6px;">Déjanos tu opinión (Opcional):</label>
                    <textarea id="modalComentario" name="comentario" rows="3" placeholder="Escribe tu experiencia aquí..." style="width: 100%; border: 1px solid #cbd5e1; border-radius: 8px; padding: 10px;"></textarea>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" onclick="cerrarModalCalificar()" style="...">Cancelar</button>
                    <button type="submit" style="...">Guardar Calificación</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    function abrirModalCalificar(idCita, nombreMedico) {
        console.log("DEBUG: ID recibido en JS =", idCita); 
        
        document.getElementById('modalIdCita').value = idCita;
        document.getElementById('modalNombreMedico').innerText = nombreMedico;
        
        console.log("DEBUG: Valor en el input oculto =", document.getElementById('modalIdCita').value);
        
        document.getElementById('modalCalificar').style.display = 'flex';
    }

    function cerrarModalCalificar() {
        document.getElementById('modalCalificar').style.display = 'none';
    }

    const estrellas = document.querySelectorAll('.star-input');
    estrellas.forEach(estrella => {
        estrella.addEventListener('click', function() {
            const valor = this.getAttribute('data-value');
            document.getElementById('inputValorCalificacion').value = valor;
            actualizarEstrellas(valor);
        });

        estrella.addEventListener('mouseover', function() {
            actualizarEstrellas(this.getAttribute('data-value'));
        });

        estrella.addEventListener('mouseleave', function() {
            actualizarEstrellas(document.getElementById('inputValorCalificacion').value);
        });
    });

    function actualizarEstrellas(valor) {
        estrellas.forEach(est => {
            if (est.getAttribute('data-value') <= valor) {
                est.classList.remove('fa-regular');
                est.classList.add('fa-solid');
                est.style.color = '#f59e0b';
            } else {
                est.classList.remove('fa-solid');
                est.classList.add('fa-regular');
                est.style.color = '#cbd5e1';
            }
        });
    }

    function resetEstrellas() {
        estrellas.forEach(est => {
            est.classList.remove('fa-solid');
            est.classList.add('fa-regular');
            est.style.color = '#cbd5e1';
        });
    }

        document.getElementById('formCalificarCita').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const idCita = document.getElementById('modalIdCita').value;
    const calificacion = document.getElementById('inputValorCalificacion').value;
    const comentario = document.getElementById('modalComentario').value;

    const params = new URLSearchParams();
    params.append('id_cita', idCita);
    params.append('calificacion', calificacion);
    params.append('comentario', comentario);

    const urlFinal = '/DSS_PrimeraFase-main/app/views/reportes/guardar_calificaciones.php?' + params.toString();

    console.log("RUTA FINAL CONSTRUIDA:", urlFinal);

    fetch(urlFinal, {
        method: 'GET'
    })
    .then(response => {
        if (!response.ok) throw new Error('Error ' + response.status);
        return response.json();
    })
    .then(data => {
        alert(data.message);
        if(data.success) location.reload();
    })
    .catch(error => {
        console.error("EL ERROR ESTÁ AQUÍ:", error);
        alert("El servidor no encuentra el archivo. Revisa si se llama 'guardar_calificacion.php' o 'guardar_calificaciones.php'");
    });
});
    </script>

    // <?php include __DIR__ . '/../layouts/scriptsPacientes.php'; ?>
</body>
</html>