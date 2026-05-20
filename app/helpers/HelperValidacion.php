<?php

/**
 * Helper de Validaciones y Errores
 * Contiene funciones reutilizables para validar y manejar errores
 */

// ==============================
// VALIDACIONES
// ==============================

/**
 * Valida que un campo no esté vacío
 */
function validarNoVacio($valor, $nombreCampo = 'Campo') {
    if (empty(trim($valor))) {
        throw new Exception("$nombreCampo es obligatorio");
    }
    return true;
}

/**
 * Valida un email
 */
function validarEmail($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("El correo '$email' no es válido");
    }
    return true;
}

/**
 * Valida un teléfono
 */
function validarTelefono($telefono) {
    $regex = '/^\+?[0-9\-\s\(\)]{7,}$/';
    if (!preg_match($regex, $telefono)) {
        throw new Exception("El teléfono '$telefono' no es válido");
    }
    return true;
}

/**
 * Valida una fecha
 */
function validarFecha($fecha) {
    $fechaObj = DateTime::createFromFormat('Y-m-d', $fecha);
    if (!$fechaObj || $fechaObj->format('Y-m-d') !== $fecha) {
        throw new Exception("La fecha '$fecha' no es válida");
    }
    
    if ($fechaObj > new DateTime()) {
        throw new Exception("La fecha debe ser anterior a hoy");
    }
    
    return true;
}

/**
 * Valida un número en rango
 */
function validarRango($valor, $min, $max, $nombreCampo = 'Valor') {
    if (!is_numeric($valor)) {
        throw new Exception("$nombreCampo debe ser un número");
    }
    
    $numero = floatval($valor);
    if ($numero < $min || $numero > $max) {
        throw new Exception("$nombreCampo debe estar entre $min y $max");
    }
    
    return true;
}

/**
 * Valida un número de identificación
 */
function validarIdentificacion($numero) {
    $regex = '/^[A-Z0-9]{6,20}$/';
    if (!preg_match($regex, $numero)) {
        throw new Exception("El número de identificación '$numero' no es válido");
    }
    return true;
}

/**
 * Valida que dos valores sean iguales
 */
function validarIguales($valor1, $valor2, $nombreCampo = 'Valores') {
    if ($valor1 !== $valor2) {
        throw new Exception("Los $nombreCampo no coinciden");
    }
    return true;
}

/**
 * Valida un URL
 */
function validarURL($url) {
    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        throw new Exception("La URL '$url' no es válida");
    }
    return true;
}

/**
 * Valida longitud de texto
 */
function validarLongitud($texto, $min, $max, $nombreCampo = 'Texto') {
    $longitud = strlen($texto);
    if ($longitud < $min || $longitud > $max) {
        throw new Exception("$nombreCampo debe tener entre $min y $max caracteres");
    }
    return true;
}

/**
 * Valida que solo contenga números
 */
function validarNumeros($valor) {
    if (!ctype_digit($valor)) {
        throw new Exception("Este campo solo debe contener números");
    }
    return true;
}

/**
 * Valida que solo contenga letras
 */
function validarLetras($valor) {
    if (!ctype_alpha($valor)) {
        throw new Exception("Este campo solo debe contener letras");
    }
    return true;
}

// ==============================
// SANITIZACIÓN DE DATOS
// ==============================

/**
 * Sanitiza un string para prevenir XSS
 */
function sanitizarString($texto) {
    return htmlspecialchars(trim($texto), ENT_QUOTES, 'UTF-8');
}

/**
 * Sanitiza un email
 */
function sanitizarEmail($email) {
    return filter_var(trim($email), FILTER_SANITIZE_EMAIL);
}

/**
 * Sanitiza un número
 */
function sanitizarNumero($numero) {
    return filter_var($numero, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
}

/**
 * Sanitiza una URL
 */
function sanitizarURL($url) {
    return filter_var($url, FILTER_SANITIZE_URL);
}

/**
 * Sanitiza datos de un array (como $_POST)
 */
function sanitizarArray($array) {
    $sanitizado = [];
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $sanitizado[$key] = sanitizarArray($value);
        } else {
            $sanitizado[$key] = sanitizarString($value);
        }
    }
    return $sanitizado;
}

// ==============================
// MANEJO DE SESIONES DE ERROR/ÉXITO
// ==============================

/**
 * Obtiene y limpia mensajes de sesión
 */
function obtenerMensaje($tipo) {
    if (!isset($_SESSION[$tipo])) {
        return null;
    }
    
    $mensaje = $_SESSION[$tipo];
    unset($_SESSION[$tipo]);
    
    return $mensaje;
}

/**
 * Obtiene mensaje de éxito
 */
function obtenerExito() {
    return obtenerMensaje('success');
}

/**
 * Obtiene mensaje de error
 */
function obtenerError() {
    return obtenerMensaje('error');
}

/**
 * Obtiene mensaje de advertencia
 */
function obtenerAdvertencia() {
    return obtenerMensaje('warning');
}

/**
 * Obtiene mensaje de información
 */
function obtenerInfo() {
    return obtenerMensaje('info');
}

/**
 * Establece mensaje de sesión
 */
function establecerMensaje($tipo, $mensaje) {
    $_SESSION[$tipo] = $mensaje;
}

// ==============================
// COMPONENTES HTML DE MENSAJES
// ==============================

/**
 * Genera HTML para alerta de éxito
 */
function generarAlertaExito($mensaje) {
    if (!$mensaje) return '';
    
    return "
    <div class='alert alert-success'>
        <i class='fas fa-check-circle'></i>
        <span>$mensaje</span>
        <button class='alert-close' onclick='this.parentElement.style.display=\"none\";'>&times;</button>
    </div>
    ";
}

/**
 * Genera HTML para alerta de error
 */
function generarAlertaError($mensaje) {
    if (!$mensaje) return '';
    
    return "
    <div class='alert alert-error'>
        <i class='fas fa-exclamation-circle'></i>
        <span>$mensaje</span>
        <button class='alert-close' onclick='this.parentElement.style.display=\"none\";'>&times;</button>
    </div>
    ";
}

/**
 * Genera HTML para alerta de advertencia
 */
function generarAlertaAdvertencia($mensaje) {
    if (!$mensaje) return '';
    
    return "
    <div class='alert alert-warning'>
        <i class='fas fa-exclamation-triangle'></i>
        <span>$mensaje</span>
        <button class='alert-close' onclick='this.parentElement.style.display=\"none\";'>&times;</button>
    </div>
    ";
}

/**
 * Genera HTML para alerta de información
 */
function generarAlertaInfo($mensaje) {
    if (!$mensaje) return '';
    
    return "
    <div class='alert alert-info'>
        <i class='fas fa-info-circle'></i>
        <span>$mensaje</span>
        <button class='alert-close' onclick='this.parentElement.style.display=\"none\";'>&times;</button>
    </div>
    ";
}

/**
 * Genera HTML para estado vacío
 */
function generarEstadoVacio($icono, $titulo, $mensaje, $boton = null) {
    $html = "
    <div class='empty-state'>
        <div class='empty-state-icon'>
            <i class='fas $icono'></i>
        </div>
        <h3 class='empty-state-title'>$titulo</h3>
        <p class='empty-state-message'>$mensaje</p>
    ";
    
    if ($boton) {
        $html .= "<a href='{$boton['url']}' class='empty-state-action'>{$boton['texto']}</a>";
    }
    
    $html .= "</div>";
    
    return $html;
}

/**
 * Genera HTML para estado de carga
 */
function generarEstadoCarga($mensaje = 'Cargando...') {
    return "
    <div class='loading'>
        <div class='loading-spinner'></div>
        <span class='loading-text'>$mensaje</span>
    </div>
    ";
}

// ==============================
// FUNCIONES DE VALIDACIÓN COMBINADAS
// ==============================

/**
 * Valida datos de paciente completo
 */
function validarDatosPaciente($datos) {
    validarNoVacio($datos['nombre'] ?? '', 'Nombre');
    validarNoVacio($datos['apellido'] ?? '', 'Apellido');
    validarNoVacio($datos['numero_identificacion'] ?? '', 'Número de identificación');
    validarNoVacio($datos['telefono'] ?? '', 'Teléfono');
    
    validarIdentificacion($datos['numero_identificacion']);
    validarTelefono($datos['telefono']);
    
    if (!empty($datos['correo'])) {
        validarEmail($datos['correo']);
    }
    
    if (!empty($datos['fecha_nacimiento'])) {
        validarFecha($datos['fecha_nacimiento']);
    }
    
    return true;
}

/**
 * Valida datos de consulta completo
 */
function validarDatosConsulta($datos) {
    validarNoVacio($datos['id_paciente'] ?? '', 'Paciente');
    validarNoVacio($datos['id_medico'] ?? '', 'Médico');
    validarNoVacio($datos['diagnostico'] ?? '', 'Diagnóstico');
    
    if (!empty($datos['temperatura'])) {
        validarRango($datos['temperatura'], 35, 40, 'Temperatura');
    }
    
    if (!empty($datos['peso'])) {
        validarRango($datos['peso'], 30, 300, 'Peso');
    }
    
    if (!empty($datos['altura'])) {
        validarRango($datos['altura'], 1, 2.5, 'Altura');
    }
    
    return true;
}

/**
 * Valida datos de calificación completo
 */
function validarDatosCalificacion($datos) {
    validarNoVacio($datos['id_consulta'] ?? '', 'Consulta');
    validarNoVacio($datos['id_paciente'] ?? '', 'Paciente');
    validarNoVacio($datos['puntuacion'] ?? '', 'Puntuación');
    
    validarRango($datos['puntuacion'], 1, 5, 'Puntuación');
    
    return true;
}

// ==============================
// LOGGING DE ERRORES
// ==============================

/**
 * Registra un error en archivo de log
 */
function registrarError($mensaje, $tipo = 'ERROR') {
    $logFile = __DIR__ . '/../../logs/error_' . date('Y-m-d') . '.log';
    
    // Crear directorio si no existe
    if (!is_dir(dirname($logFile))) {
        mkdir(dirname($logFile), 0755, true);
    }
    
    $timestamp = date('Y-m-d H:i:s');
    $linea = "[$timestamp] [$tipo] $mensaje\n";
    
    file_put_contents($logFile, $linea, FILE_APPEND);
}

/**
 * Captura excepciones y las registra
 */
function capturarExcepcion($excepcion) {
    registrarError($excepcion->getMessage(), 'EXCEPTION');
    registrarError($excepcion->getTraceAsString(), 'TRACE');
    
    // En desarrollo mostrar el error, en producción mostrar genérico
    if (isset($_ENV['APP_ENV']) && $_ENV['APP_ENV'] === 'development') {
        throw $excepcion;
    } else {
        throw new Exception("Ha ocurrido un error. Por favor, intenta de nuevo más tarde.");
    }
}

?>
