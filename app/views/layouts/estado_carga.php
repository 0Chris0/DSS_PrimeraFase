<?php
/**
 * Componente: Estado de Carga
 * Se usa para mostrar un loader mientras se cargan datos
 */

require_once __DIR__ . '/../../app/helpers/HelperValidacion.php';

// Parámetro esperado:
// $mensaje: texto de carga (opcional)

if(!isset($mensaje)) $mensaje = 'Cargando datos...';

?>

<?php echo generarEstadoCarga($mensaje); ?>
