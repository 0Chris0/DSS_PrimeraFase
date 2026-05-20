<?php
/**
 * Componente: Estado Vacío
 * Se usa cuando no hay registros para mostrar
 */

// CORRECCIÓN: Se eliminó el '/app' duplicado de la ruta absoluta
require_once __DIR__ . '/../../helpers/HelperValidacion.php';

// Parámetros esperados:
// $icono: clase Font Awesome (ej: fa-inbox)
// $titulo: título del mensaje
// $mensaje: descripción
// $boton: array con 'url' y 'texto' (opcional)

if(!isset($icono)) $icono = 'fa-inbox';
if(!isset($titulo)) $titulo = 'Sin registros';
if(!isset($mensaje)) $mensaje = 'No hay datos para mostrar en este momento';

?>

<?php echo generarEstadoVacio($icono, $titulo, $mensaje, $boton ?? null); ?>
