<?php
/**
 * Componente: Mostrar Alertas
 * Se usa en cualquier página para mostrar mensajes de sesión
 */

require_once (defined('RAIZ_APP') ? RAIZ_APP : __DIR__ . '/../../../app/') . 'helpers/HelperValidacion.php';

$mensaje_exito = obtenerExito();
$mensaje_error = obtenerError();
$mensaje_advertencia = obtenerAdvertencia();
$mensaje_info = obtenerInfo();
?>

<?php if($mensaje_exito): ?>
    <?php echo generarAlertaExito($mensaje_exito); ?>
<?php endif; ?>

<?php if($mensaje_error): ?>
    <?php echo generarAlertaError($mensaje_error); ?>
<?php endif; ?>

<?php if($mensaje_advertencia): ?>
    <?php echo generarAlertaAdvertencia($mensaje_advertencia); ?>
<?php endif; ?>

<?php if($mensaje_info): ?>
    <?php echo generarAlertaInfo($mensaje_info); ?>
<?php endif; ?>
