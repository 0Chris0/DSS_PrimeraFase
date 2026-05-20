# 📊 Documentación: Modelos y Controladores Completados

## Resumen Total

Se han creado **9 Modelos** + **6 Controladores** para un sistema completo de gestión médica.

---

## 🎯 Entidades Principales (CRUD Completo)

### 1. **Pacientes**
**Archivo:** `app/models/Paciente.php` | `app/controllers/PacienteController.php`

**Operaciones:**
- ✅ Crear paciente
- ✅ Obtener todos los pacientes
- ✅ Obtener paciente por ID
- ✅ Actualizar datos del paciente
- ✅ Eliminar paciente
- ✅ Buscar por número de identificación
- ✅ Contar total de pacientes

**Campos:**
```
id_paciente, nombre_paciente, apellido_paciente, correo_paciente,
telefono_paciente, fecha_nacimiento, genero, direccion,
numero_identificacion, fecha_registro
```

---

### 2. **Médicos**
**Archivo:** `app/models/Medico.php` | `app/controllers/MedicoController.php`

**Operaciones:**
- ✅ Crear médico
- ✅ Obtener todos los médicos
- ✅ Obtener médico por ID
- ✅ Obtener médicos por especialidad
- ✅ Actualizar datos del médico
- ✅ Eliminar médico
- ✅ Buscar por nombre
- ✅ Obtener calificación promedio
- ✅ Contar total de médicos

**Campos:**
```
id_medico, nombre_medico, id_especialidad, telefono
```

---

### 3. **Especialidades**
**Archivo:** `app/models/Especialidad.php` | `app/controllers/EspecialidadController.php`

**Operaciones:**
- ✅ Crear especialidad
- ✅ Obtener todas las especialidades
- ✅ Obtener especialidad por ID
- ✅ Actualizar especialidad
- ✅ Eliminar especialidad
- ✅ Buscar por nombre
- ✅ Obtener cantidad de médicos por especialidad
- ✅ Contar total

**Campos:**
```
id_especialidad, nombre_especialidad, descripcion
```

---

### 4. **Citas**
**Archivo:** `app/models/Cita.php` | `app/controllers/CitasController.php` (mejorado)

**Operaciones:**
- ✅ Crear cita
- ✅ Obtener todas las citas
- ✅ Obtener cita por ID
- ✅ Obtener citas por paciente
- ✅ Obtener citas por médico
- ✅ Obtener citas por estado
- ✅ Obtener citas próximas (próximos 7 días)
- ✅ Actualizar cita
- ✅ Cambiar estado de cita
- ✅ Eliminar cita
- ✅ Contar total

**Campos:**
```
id_cita, id_paciente, id_medico, fecha_cita, hora_cita,
estado, motivo_cita
```

**Estados Válidos:** Programada, Completada, Cancelada, Reprogramada

---

### 5. **Consultas**
**Archivo:** `app/models/Consulta.php` | `app/controllers/ConsultaController.php`

**Operaciones:**
- ✅ Crear consulta
- ✅ Obtener todas las consultas
- ✅ Obtener consulta por ID
- ✅ Obtener consultas por paciente
- ✅ Obtener consultas por médico
- ✅ Actualizar consulta
- ✅ Eliminar consulta
- ✅ Contar total

**Campos:**
```
id_consulta, id_paciente, id_medico, fecha_consulta,
diagnóstico, tratamiento, observaciones,
presión_arterial, temperatura, peso, altura
```

---

### 6. **Calificaciones**
**Archivo:** `app/models/Calificacion.php` | `app/controllers/CalificacionController.php`

**Operaciones:**
- ✅ Crear calificación (1-5 estrellas)
- ✅ Obtener todas las calificaciones
- ✅ Obtener calificación por ID
- ✅ Obtener calificaciones por consulta
- ✅ Obtener calificaciones por paciente
- ✅ Obtener calificaciones por médico
- ✅ Obtener promedio de calificación de médico
- ✅ Actualizar calificación
- ✅ Eliminar calificación
- ✅ Contar total

**Campos:**
```
id_calificacion, id_consulta, id_paciente,
puntuacion (1-5), comentario, fecha_calificacion
```

---

## 🛡️ Características Técnicas

### Todas los Modelos incluyen:

✅ **Try-Catch Completo**
```php
try {
    // Operación
} catch (PDOException $e) {
    throw new Exception("Error: " . $e->getMessage());
}
```

✅ **Prepared Statements** (previenen SQL injection)
```php
$stmt = $this->conexion->prepare($sql);
$stmt->execute([$param1, $param2]);
```

✅ **Métodos Reutilizables**
```php
public function obtenerTodos() { ... }
public function obtenerPorId($id) { ... }
public function crear(...) { ... }
public function actualizar(...) { ... }
public function eliminar($id) { ... }
```

### Todos los Controladores incluyen:

✅ **Validaciones Backend**
```php
validarNoVacio($_POST['campo'], 'Nombre del campo');
validarEmail($_POST['correo']);
```

✅ **Sanitización de Datos**
```php
sanitizarString($_POST['nombre'])
sanitizarEmail($_POST['correo'])
```

✅ **Manejo de Sesiones**
```php
$_SESSION['success'] = "Operación exitosa";
$_SESSION['error'] = "Error en la operación";
```

✅ **Respuestas JSON para AJAX**
```php
if(!empty($_GET['ajax'])){
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'data' => $data]);
}
```

---

## 📁 Estructura de Archivos

```
app/
├── models/
│   ├── Paciente.php          ✅
│   ├── Medico.php            ✅
│   ├── Especialidad.php      ✅
│   ├── Cita.php              ✅
│   ├── Consulta.php          ✅
│   └── Calificacion.php      ✅
│
├── controllers/
│   ├── PacienteController.php        ✅
│   ├── MedicoController.php          ✅ (NUEVO)
│   ├── EspecialidadController.php    ✅ (NUEVO)
│   ├── CitasController.php           ✅ (MEJORADO)
│   ├── ConsultaController.php        ✅
│   ├── CalificacionController.php    ✅
│   └── AuthController.php
│
├── helpers/
│   └── HelperValidacion.php  ✅
│
└── views/
    ├── pacientes/
    │   ├── index_mejorado.php
    │   └── create_mejorado.php
    ├── consultas/
    │   └── index_mejorado.php
    ├── medicos/
    │   ├── index.php
    │   ├── create.php
    │   ├── edit.php
    │   └── show.php
    ├── citas/
    │   ├── index.php
    │   ├── create.php
    │   ├── edit.php
    │   └── calendar.php
    ├── calificaciones/
    │   └── index.php
    ├── layouts/
    │   ├── alertas.php
    │   ├── estado_vacio.php
    │   └── estado_carga.php
    └── reportes/
        ├── index.php
        ├── calificaciones.php
        ├── especialidades.php
        ├── historial.php
        ├── pacientesMedico.php
        └── servicios.php

public/
├── js/
│   └── validaciones.js
└── css/
    └── validaciones.css

config/
└── db_reporte_especialidades.sql  ✅ (ACTUALIZADO)
```

---

## 🔗 Relaciones entre Entidades

```
ESPECIALIDADES
     ↑
     │ (1 a muchos)
     │
   MÉDICOS
     ↑
     ├────────────────────────────────────────┐
     │ (1 a muchos)                  (1 a muchos)
     │                                        │
   CITAS                              CONSULTAS
     ↑                                   ↑
     │ (1 a muchos)                       │ (1 a muchos)
     │                                    │
  PACIENTES ←─────────────────────────────┘
     ↑
     │ (1 a muchos)
     │
 CALIFICACIONES
```

---

## 📝 Ejemplo de Uso

### Crear un Paciente (PHP)
```php
require_once __DIR__ . '/../../config/conexion.php';
require_once __DIR__ . '/../models/Paciente.php';

$pacienteModel = new Paciente($conexion);

try {
    $resultado = $pacienteModel->crear(
        'Juan',
        'García',
        'juan@email.com',
        '555-1234',
        '1990-05-15',
        'Masculino',
        'Calle 123',
        '12345678A'
    );
    
    if($resultado){
        echo "Paciente creado exitosamente";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
```

### Obtener Médicos por Especialidad (PHP)
```php
$medicoModel = new Medico($conexion);

$medicos = $medicoModel->obtenerPorEspecialidad(1); // 1 = Cardiología
```

### Validar Datos en Controlador (PHP)
```php
if($_POST['accion'] == 'crear'){
    try {
        validarNoVacio($_POST['nombre'], 'Nombre');
        validarEmail($_POST['correo']);
        validarTelefono($_POST['telefono']);
        
        // Crear paciente...
        $resultado = $pacienteModel->crear(...);
        
        if($resultado){
            $_SESSION['success'] = "Paciente creado";
            header("Location: index.php");
        }
    } catch(Exception $e){
        $_SESSION['error'] = $e->getMessage();
        header("Location: create.php");
    }
}
```

### Obtener Datos vía AJAX (JavaScript)
```javascript
// Obtener todos los médicos en JSON
fetch('../../controllers/MedicoController.php?accion=listar&ajax=1')
    .then(response => response.json())
    .then(data => {
        if(data.success){
            console.log(data.data); // Array de médicos
        }
    });
```

---

## ✨ Validaciones Implementadas

### Backend
- ✅ Campos no vacíos
- ✅ Emails válidos
- ✅ Teléfonos válidos
- ✅ Fechas válidas
- ✅ Rangos numéricos
- ✅ Números de identificación
- ✅ Sanitización XSS

### Frontend
- ✅ Validación en tiempo real
- ✅ Mensajes de error dinámicos
- ✅ Estados vacíos
- ✅ Loaders de carga
- ✅ Alertas (éxito, error, advertencia)

---

## 🚀 Próximos Pasos (Opcional)

Si deseas expandir el sistema:

1. **Modelo Usuarios** - Gestionar usuarios del sistema
2. **Modelo Reportes** - Generar reportes estadísticos
3. **Modelo Auditoría** - Registrar cambios en el sistema
4. **API REST** - Crear endpoints JSON para terceros
5. **Notificaciones** - Email/SMS para recordatorio de citas

---

## 📞 Contacto y Soporte

Toda la estructura sigue:
- ✅ Patrón MVC
- ✅ Seguridad (PDO, XSS prevention)
- ✅ Manejo de errores robusto
- ✅ Validaciones en dos capas
- ✅ Código documentado


