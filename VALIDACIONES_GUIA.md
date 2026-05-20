# Guía de Validaciones y Manejo de Errores

## Descripción General

Este documento explica cómo usar el sistema de validaciones y manejo de errores del proyecto.

---

## 1. Validaciones en Frontend (JavaScript)

### Ubicación
`public/js/validaciones.js`

### Funciones Disponibles

#### Validar Campo Vacío
```javascript
validarNoVacio(idCampo, nombreCampo)
```
**Ejemplo:**
```javascript
if(!validarNoVacio('nombre', 'Nombre')) {
    return false;
}
```

#### Validar Email
```javascript
validarEmail(idCampo)
```
**Ejemplo:**
```javascript
validarEmail('correo');
```

#### Validar Teléfono
```javascript
validarTelefono(idCampo)
```
**Ejemplo:**
```javascript
validarTelefono('telefono');
```

#### Validar Fecha
```javascript
validarFecha(idCampo)
```
**Ejemplo:**
```javascript
validarFecha('fecha_nacimiento');
```

#### Validar Rango Numérico
```javascript
validarRango(idCampo, min, max, nombreCampo)
```
**Ejemplo:**
```javascript
validarRango('temperatura', 35, 40, 'Temperatura');
validarRango('puntuacion', 1, 5, 'Puntuación');
```

#### Validar Identificación
```javascript
validarIdentificacion(idCampo)
```
**Ejemplo:**
```javascript
validarIdentificacion('numero_identificacion');
```

### Funciones Combinadas

#### Validar Formulario de Pacientes
```javascript
validarFormularioPaciente()
```

#### Validar Formulario de Consultas
```javascript
validarFormularioConsulta()
```

#### Validar Formulario de Calificaciones
```javascript
validarFormularioCalificacion()
```

### Uso en HTML

```html
<!-- Incluir script -->
<script src="public/js/validaciones.js"></script>

<!-- Formulario con validación -->
<form onsubmit="return validarFormularioPaciente();">
    <div class="form-group">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre">
    </div>
    
    <button type="submit">Enviar</button>
</form>
```

---

## 2. Validaciones en Backend (PHP)

### Ubicación
`app/helpers/HelperValidacion.php`

### Importar el Helper
```php
require_once __DIR__ . '/../../app/helpers/HelperValidacion.php';
```

### Funciones de Validación

#### Validar No Vacío
```php
validarNoVacio($valor, $nombreCampo)

// Ejemplo
validarNoVacio($_POST['nombre'], 'Nombre');
```

#### Validar Email
```php
validarEmail($email)

// Ejemplo
validarEmail($_POST['correo']);
```

#### Validar Teléfono
```php
validarTelefono($telefono)

// Ejemplo
validarTelefono($_POST['telefono']);
```

#### Validar Fecha
```php
validarFecha($fecha) // Formato: 'YYYY-MM-DD'

// Ejemplo
validarFecha($_POST['fecha_nacimiento']);
```

#### Validar Rango
```php
validarRango($valor, $min, $max, $nombreCampo)

// Ejemplo
validarRango($_POST['temperatura'], 35, 40, 'Temperatura');
```

### Validaciones Combinadas

#### Validar Datos de Paciente
```php
validarDatosPaciente($_POST);
```

#### Validar Datos de Consulta
```php
validarDatosConsulta($_POST);
```

#### Validar Datos de Calificación
```php
validarDatosCalificacion($_POST);
```

### Ejemplo Completo en Controlador

```php
<?php
require_once __DIR__ . '/../../app/helpers/HelperValidacion.php';
require_once __DIR__ . '/../models/Paciente.php';

if(isset($_POST['accion'])){
    if($_POST['accion'] == 'crear'){
        try {
            // Validar datos
            validarDatosPaciente($_POST);
            
            // Sanitizar datos
            $nombre = sanitizarString($_POST['nombre']);
            $correo = sanitizarEmail($_POST['correo']);
            
            // Crear paciente
            $pacienteModel = new Paciente($conexion);
            $resultado = $pacienteModel->crear($nombre, ...);
            
            if($resultado){
                $_SESSION['success'] = "Paciente creado exitosamente";
                header("Location: ../views/pacientes/index.php");
            }
        } catch(Exception $e){
            $_SESSION['error'] = $e->getMessage();
            header("Location: ../views/pacientes/create.php");
        }
    }
}
?>
```

---

## 3. Funciones de Sanitización

### Sanitizar String
```php
sanitizarString($texto)
```

### Sanitizar Email
```php
sanitizarEmail($email)
```

### Sanitizar Número
```php
sanitizarNumero($numero)
```

### Sanitizar Array
```php
sanitizarArray($_POST)
```

---

## 4. Manejo de Mensajes de Sesión

### Establecer Mensaje
```php
$_SESSION['success'] = "Operación exitosa";
$_SESSION['error'] = "Error en la operación";
$_SESSION['warning'] = "Advertencia";
$_SESSION['info'] = "Información";
```

### Obtener y Limpiar Mensaje
```php
$mensaje = obtenerExito();    // y limpia $_SESSION['success']
$mensaje = obtenerError();     // y limpia $_SESSION['error']
$mensaje = obtenerAdvertencia(); // y limpia $_SESSION['warning']
$mensaje = obtenerInfo();      // y limpia $_SESSION['info']
```

---

## 5. Componentes HTML de Alertas

### Alertas en Vistas
En cualquier vista, incluye las alertas:

```php
<?php include __DIR__ . '/../layouts/alertas.php'; ?>
```

Esto mostrará automáticamente los mensajes de sesión con estilos.

### Generar Alertas Manualmente
```php
<?php echo generarAlertaExito("Operación exitosa"); ?>
<?php echo generarAlertaError("Error en la operación"); ?>
<?php echo generarAlertaAdvertencia("Advertencia"); ?>
<?php echo generarAlertaInfo("Información"); ?>
```

---

## 6. Estado Vacío

### Incluir Componente
```php
<?php
$icono = 'fa-inbox';
$titulo = 'Sin registros';
$mensaje = 'No hay datos disponibles';
$boton = ['url' => 'create.php', 'texto' => 'Crear'];
include __DIR__ . '/../layouts/estado_vacio.php';
?>
```

### O usar la función
```php
<?php echo generarEstadoVacio('fa-inbox', 'Sin registros', 'No hay datos', ['url' => 'create.php', 'texto' => 'Crear']); ?>
```

---

## 7. Estado de Carga

### Incluir Componente
```php
<?php include __DIR__ . '/../layouts/estado_carga.php'; ?>
```

### O usar la función
```php
<?php echo generarEstadoCarga('Cargando datos...'); ?>
```

---

## 8. CSS de Validaciones

### Ubicación
`public/css/validaciones.css`

### Clases Disponibles

#### Alertas
```html
<div class="alert alert-success">Éxito</div>
<div class="alert alert-error">Error</div>
<div class="alert alert-warning">Advertencia</div>
<div class="alert alert-info">Información</div>
```

#### Estado Vacío
```html
<div class="empty-state">
    <div class="empty-state-icon"><i class="fas fa-inbox"></i></div>
    <h3 class="empty-state-title">Sin registros</h3>
    <p class="empty-state-message">No hay datos</p>
</div>
```

#### Estado de Carga
```html
<div class="loading">
    <div class="loading-spinner"></div>
    <span class="loading-text">Cargando...</span>
</div>
```

---

## 9. Ejemplo: Crear Nueva Vista con Validaciones

### crear_paciente.php
```php
<?php
session_start();
require_once __DIR__ . '/../../app/helpers/HelperValidacion.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Crear Paciente</title>
    <link rel="stylesheet" href="../../public/css/validaciones.css">
</head>
<body>
    <!-- Mostrar Alertas -->
    <?php include __DIR__ . '/layouts/alertas.php'; ?>

    <!-- Formulario con validación -->
    <form id="formulario" method="POST" action="../../controllers/PacienteController.php" 
          onsubmit="return validarFormularioPaciente();">
        
        <input type="hidden" name="accion" value="crear">
        
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" placeholder="Nombre">
        </div>
        
        <div class="form-group">
            <label for="correo">Correo</label>
            <input type="email" id="correo" name="correo" placeholder="correo@email.com">
        </div>
        
        <button type="submit">Crear</button>
    </form>

    <!-- Scripts -->
    <script src="../../public/js/validaciones.js"></script>
</body>
</html>
```

---

## 10. Notas Importantes

### Seguridad
- **Siempre sanitizar** datos del usuario en backend
- **Validar en frontend** para mejor UX
- **Validar en backend** para seguridad
- Usar **PDO prepared statements** para evitar SQL injection

### Errores
- Los errores se almacenan en `logs/error_YYYY-MM-DD.log`
- Usa `registrarError()` para log manual
- En desarrollo, errores se muestran en pantalla
- En producción, se muestran mensajes genéricos

### Mensajes de Usuario
- Usa mensajes claros y en español
- Mensajes de éxito: "Operación realizada exitosamente"
- Mensajes de error: "Error: [descripción del problema]"
- Mensajes de validación: "El campo [nombre] es obligatorio"

---

## 11. Archivos Creados

```
public/
├── js/
│   └── validaciones.js              # Validaciones en frontend
├── css/
│   └── validaciones.css             # Estilos para validaciones

app/
├── helpers/
│   └── HelperValidacion.php        # Funciones de validación y manejo de errores
├── views/
│   └── layouts/
│       ├── alertas.php              # Componente de alertas
│       ├── estado_vacio.php         # Componente de estado vacío
│       └── estado_carga.php         # Componente de carga
├── models/
│   ├── Paciente.php                # Modelo con try-catch
│   ├── Consulta.php                # Modelo con try-catch
│   └── Calificacion.php            # Modelo con try-catch
└── controllers/
    ├── PacienteController.php       # Controlador con validaciones
    ├── ConsultaController.php       # Controlador con validaciones
    └── CalificacionController.php   # Controlador con validaciones

views/
├── pacientes/
│   └── index_mejorado.php           # Vista mejorada de listado
│   └── create_mejorado.php          # Vista mejorada de formulario
├── consultas/
│   └── index_mejorado.php           # Vista mejorada de consultas
```

---

## Preguntas Frecuentes

**P: ¿Por qué validar en frontend y backend?**
A: Frontend para mejor UX (respuesta rápida), backend para seguridad (no confiar en cliente).

**P: ¿Cómo personalizar mensajes de error?**
A: En los validadores, cambia el mensaje en la excepción `throw new Exception("Tu mensaje")`.

**P: ¿Cómo agregar más reglas de validación?**
A: Agrega nuevas funciones en `HelperValidacion.php` y úsalas en controladores.

**P: ¿Dónde se guardan los logs de error?**
A: En `logs/error_YYYY-MM-DD.log`

---

**¡Listo! Tu proyecto tiene un sistema completo de validaciones y manejo de errores.**
