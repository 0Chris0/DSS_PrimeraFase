/**
 * Sistema de Validaciones del Formulario
 * Contiene funciones para validar datos en el frontend
 */

// ==============================
// VALIDACIONES DE CAMPOS
// ==============================

/**
 * Valida que un campo no esté vacío
 */
function validarNoVacio(campo, nombreCampo) {
    const valor = document.getElementById(campo)?.value.trim();
    
    if (!valor) {
        mostrarError(campo, `${nombreCampo} es obligatorio`);
        return false;
    }
    
    limpiarError(campo);
    return true;
}

/**
 * Valida un email
 */
function validarEmail(campo) {
    const valor = document.getElementById(campo)?.value.trim();
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
    if (valor && !regex.test(valor)) {
        mostrarError(campo, "El correo no es válido");
        return false;
    }
    
    limpiarError(campo);
    return true;
}

/**
 * Valida un teléfono
 */
function validarTelefono(campo) {
    const valor = document.getElementById(campo)?.value.trim();
    const regex = /^\+?[0-9\-\s\(\)]{7,}$/;
    
    if (valor && !regex.test(valor)) {
        mostrarError(campo, "El teléfono no es válido");
        return false;
    }
    
    limpiarError(campo);
    return true;
}

/**
 * Valida una fecha
 */
function validarFecha(campo) {
    const valor = document.getElementById(campo)?.value;
    
    if (!valor) {
        limpiarError(campo);
        return true;
    }
    
    const fecha = new Date(valor);
    const hoy = new Date();
    
    if (fecha >= hoy) {
        mostrarError(campo, "La fecha debe ser anterior a hoy");
        return false;
    }
    
    limpiarError(campo);
    return true;
}

/**
 * Valida un número en rango
 */
function validarRango(campo, min, max, nombreCampo) {
    const valor = document.getElementById(campo)?.value;
    
    if (!valor) {
        mostrarError(campo, `${nombreCampo} es obligatorio`);
        return false;
    }
    
    const numero = parseFloat(valor);
    
    if (isNaN(numero) || numero < min || numero > max) {
        mostrarError(campo, `${nombreCampo} debe estar entre ${min} y ${max}`);
        return false;
    }
    
    limpiarError(campo);
    return true;
}

/**
 * Valida que dos campos sean iguales (ej: contraseñas)
 */
function validarIguales(campo1, campo2, nombreCampo) {
    const valor1 = document.getElementById(campo1)?.value;
    const valor2 = document.getElementById(campo2)?.value;
    
    if (valor1 !== valor2) {
        mostrarError(campo2, `Los ${nombreCampo} no coinciden`);
        return false;
    }
    
    limpiarError(campo2);
    return true;
}

/**
 * Valida un número de identificación
 */
function validarIdentificacion(campo) {
    const valor = document.getElementById(campo)?.value.trim();
    const regex = /^[A-Z0-9]{6,20}$/;
    
    if (valor && !regex.test(valor)) {
        mostrarError(campo, "El número de identificación no es válido");
        return false;
    }
    
    limpiarError(campo);
    return true;
}

// ==============================
// MOSTRAR Y LIMPIAR ERRORES
// ==============================

/**
 * Muestra error bajo un campo
 */
function mostrarError(campo, mensaje) {
    const elemento = document.getElementById(campo);
    if (!elemento) return;
    
    // Remover error previo si existe
    const errorExistente = elemento.parentElement?.querySelector('.error-message');
    if (errorExistente) {
        errorExistente.remove();
    }
    
    // Agregar clase de error al campo
    elemento.classList.add('error');
    
    // Crear y mostrar mensaje de error
    const errorDiv = document.createElement('div');
    errorDiv.className = 'error-message';
    errorDiv.textContent = mensaje;
    elemento.parentElement?.appendChild(errorDiv);
}

/**
 * Limpia el error de un campo
 */
function limpiarError(campo) {
    const elemento = document.getElementById(campo);
    if (!elemento) return;
    
    elemento.classList.remove('error');
    const errorDiv = elemento.parentElement?.querySelector('.error-message');
    if (errorDiv) {
        errorDiv.remove();
    }
}

/**
 * Limpia todos los errores
 */
function limpiarTodosLosErrores() {
    const errores = document.querySelectorAll('.error-message');
    errores.forEach(error => error.remove());
    
    const campos = document.querySelectorAll('.error');
    campos.forEach(campo => campo.classList.remove('error'));
}

// ==============================
// VALIDACIÓN DE FORMULARIOS COMPLETOS
// ==============================

/**
 * Valida formulario de pacientes
 */
function validarFormularioPaciente() {
    limpiarTodosLosErrores();
    
    let esValido = true;
    
    // Campos obligatorios
    esValido &= validarNoVacio('nombre', 'Nombre');
    esValido &= validarNoVacio('apellido', 'Apellido');
    esValido &= validarNoVacio('numero_identificacion', 'Número de identificación');
    esValido &= validarNoVacio('telefono', 'Teléfono');
    
    // Validaciones específicas
    esValido &= validarIdentificacion('numero_identificacion');
    esValido &= validarTelefono('telefono');
    esValido &= validarEmail('correo');
    esValido &= validarFecha('fecha_nacimiento');
    
    return esValido;
}

/**
 * Valida formulario de consultas
 */
function validarFormularioConsulta() {
    limpiarTodosLosErrores();
    
    let esValido = true;
    
    // Campos obligatorios
    esValido &= validarNoVacio('id_paciente', 'Paciente');
    esValido &= validarNoVacio('id_medico', 'Médico');
    esValido &= validarNoVacio('diagnostico', 'Diagnóstico');
    
    // Validaciones numéricas
    if (document.getElementById('temperatura')?.value) {
        esValido &= validarRango('temperatura', 35, 40, 'Temperatura');
    }
    if (document.getElementById('peso')?.value) {
        esValido &= validarRango('peso', 30, 300, 'Peso');
    }
    if (document.getElementById('altura')?.value) {
        esValido &= validarRango('altura', 1, 2.5, 'Altura');
    }
    
    return esValido;
}

/**
 * Valida formulario de calificaciones
 */
function validarFormularioCalificacion() {
    limpiarTodosLosErrores();
    
    let esValido = true;
    
    // Campos obligatorios
    esValido &= validarNoVacio('id_consulta', 'Consulta');
    esValido &= validarNoVacio('puntuacion', 'Puntuación');
    
    // Validar rango de puntuación
    esValido &= validarRango('puntuacion', 1, 5, 'Puntuación');
    
    return esValido;
}

// ==============================
// EVENTOS EN TIEMPO REAL
// ==============================

/**
 * Agrega validación en tiempo real a un campo
 */
function validarEnTiempoReal(idCampo, tipoCampo) {
    const elemento = document.getElementById(idCampo);
    if (!elemento) return;
    
    elemento.addEventListener('blur', function() {
        switch(tipoCampo) {
            case 'email':
                validarEmail(idCampo);
                break;
            case 'telefono':
                validarTelefono(idCampo);
                break;
            case 'fecha':
                validarFecha(idCampo);
                break;
            case 'identificacion':
                validarIdentificacion(idCampo);
                break;
            default:
                validarNoVacio(idCampo, 'Campo');
        }
    });
}

/**
 * Inicializa validaciones en tiempo real para formularios
 */
function inicializarValidaciones() {
    // Pacientes
    validarEnTiempoReal('nombre', 'text');
    validarEnTiempoReal('apellido', 'text');
    validarEnTiempoReal('numero_identificacion', 'identificacion');
    validarEnTiempoReal('telefono', 'telefono');
    validarEnTiempoReal('correo', 'email');
    validarEnTiempoReal('fecha_nacimiento', 'fecha');
    
    // Consultas
    validarEnTiempoReal('diagnostico', 'text');
    validarEnTiempoReal('temperatura', 'number');
    validarEnTiempoReal('peso', 'number');
    validarEnTiempoReal('altura', 'number');
    
    // Calificaciones
    validarEnTiempoReal('puntuacion', 'number');
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', inicializarValidaciones);
