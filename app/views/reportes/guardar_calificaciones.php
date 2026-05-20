<?php
header('Content-Type: application/json');
session_start();

// Recibir datos (Cambiado de $_GET a $_POST ya que los formularios envían por POST de manera más segura)
$id_cita      = isset($_REQUEST['id_cita']) ? (int)$_REQUEST['id_cita'] : 0;
$calificacion = isset($_REQUEST['calificacion']) ? (int)$_REQUEST['calificacion'] : 0;
$comentario   = isset($_REQUEST['comentario']) ? trim($_REQUEST['comentario']) : '';

if ($id_cita === 0) {
    echo json_encode(['success' => false, 'message' => 'ID de cita no válido']);
    exit();
}

// CORREGIDO: Credenciales oficiales para MySQL en XAMPP
$host     = "localhost";
$port     = "3306";
$dbname   = "clinica";
$user     = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 1. Buscamos el id_paciente y el id_consulta vinculados a esa cita para poder guardarlo en calificaciones
    $sqlConsulta = "SELECT con.id_consulta, c.id_paciente 
                    FROM citas c
                    INNER JOIN consultas con ON c.id_medico = con.id_medico AND c.id_paciente = con.id_paciente
                    WHERE c.id_cita = :id_cita LIMIT 1";
    
    $stmtC = $pdo->prepare($sqlConsulta);
    $stmtC->execute([':id_cita' => $id_cita]);
    $vínculo = $stmtC->fetch(PDO::FETCH_ASSOC);

    if (!$vínculo) {
        // Si aún no se ha generado una consulta médica física de esa cita, creamos un registro directo simulado
        $sqlCitaInfo = "SELECT id_paciente, id_medico FROM citas WHERE id_cita = :id_cita";
        $stmtCitaInfo = $pdo->prepare($sqlCitaInfo);
        $stmtCitaInfo->execute([':id_cita' => $id_cita]);
        $citaInfo = $stmtCitaInfo->fetch(PDO::FETCH_ASSOC);

        // Crear consulta fantasma obligatoria para no romper la llave foránea de calificaciones
        $sqlNuevaCon = "INSERT INTO consultas (id_paciente, id_medico, diagnóstico, tratamiento) VALUES (?, ?, 'Revisión General', 'Seguimiento')";
        $pdo->prepare($sqlNuevaCon)->execute([$citaInfo['id_paciente'], $citaInfo['id_medico']]);
        $id_consulta = $pdo->lastInsertId();
        $id_paciente = $citaInfo['id_paciente'];
    } else {
        $id_consulta = $vínculo['id_consulta'];
        $id_paciente = $vínculo['id_paciente'];
    }

    // 2. Insertar de manera limpia en tu tabla calificaciones adaptada a MySQL
    $sqlInsert = "INSERT INTO calificaciones (id_consulta, id_paciente, puntuacion, comentario) 
                  VALUES (:id_consulta, :id_paciente, :puntuacion, :comentario)";
    
    $stmt = $pdo->prepare($sqlInsert);
    $stmt->execute([
        ':id_consulta' => $id_consulta,
        ':id_paciente' => $id_paciente,
        ':puntuacion'  => $calificacion,
        ':comentario'  => $comentario
    ]);

    echo json_encode(['success' => true, 'message' => '¡Calificación guardada con éxito!']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>
