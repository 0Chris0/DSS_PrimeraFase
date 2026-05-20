-- 1. Limpieza de tablas (Orden inverso por las llaves foráneas)
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS calificaciones;
DROP TABLE IF EXISTS consultas;
DROP TABLE IF EXISTS citas;
DROP TABLE IF EXISTS pacientes;
DROP TABLE IF EXISTS medicos;
DROP TABLE IF EXISTS especialidades;
DROP TABLE IF EXISTS usuarios;
SET FOREIGN_KEY_CHECKS = 1;

-- 2. Creación de tablas
CREATE TABLE recursos (
    id_recurso INT AUTO_INCREMENT PRIMARY KEY,
    nombre_recurso VARCHAR(100) NOT NULL,
    tipo_recurso VARCHAR(50), -- Ej: 'Equipo', 'Insumo', 'Medicamento'
    cantidad_stock INT DEFAULT 0,
    ubicacion_almacen VARCHAR(100),
    fecha_adquisicion DATE,
    estado_recurso VARCHAR(20) DEFAULT 'Disponible' -- Ej: 'Disponible', 'En mantenimiento', 'Agotado'
) ENGINE=InnoDB;

CREATE TABLE especialidades (
    id_especialidad INT AUTO_INCREMENT PRIMARY KEY,
    nombre_especialidad VARCHAR(100) NOT NULL,
    descripcion TEXT
) ENGINE=InnoDB;

CREATE TABLE medicos (
    id_medico INT AUTO_INCREMENT PRIMARY KEY,
    nombre_medico VARCHAR(100) NOT NULL,
    id_especialidad INT NOT NULL,
    telefono VARCHAR(15),
    CONSTRAINT fk_especialidad FOREIGN KEY(id_especialidad) REFERENCES especialidades(id_especialidad)
) ENGINE=InnoDB;

CREATE TABLE pacientes (
    id_paciente INT AUTO_INCREMENT PRIMARY KEY,
    nombre_paciente VARCHAR(100) NOT NULL,
    apellido_paciente VARCHAR(100) NOT NULL,
    correo_paciente VARCHAR(100) UNIQUE,
    telefono_paciente VARCHAR(15),
    fecha_nacimiento DATE,
    genero VARCHAR(20),
    direccion TEXT,
    numero_identificacion VARCHAR(20) UNIQUE NOT NULL,
    notas TEXT,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE citas (
    id_cita INT AUTO_INCREMENT PRIMARY KEY,
    id_paciente INT NOT NULL,
    id_medico INT NOT NULL,
    fecha_cita DATE NOT NULL,
    hora_cita TIME,
    estado VARCHAR(50) DEFAULT 'Programada',
    motivo_cita TEXT,
    FOREIGN KEY(id_paciente) REFERENCES pacientes(id_paciente) ON DELETE CASCADE,
    FOREIGN KEY(id_medico) REFERENCES medicos(id_medico) ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE consultas (
    id_consulta INT AUTO_INCREMENT PRIMARY KEY,
    id_paciente INT NOT NULL,
    id_medico INT NOT NULL,
    fecha_consulta TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    diagnóstico TEXT,
    tratamiento TEXT,
    observaciones TEXT,
    presión_arterial VARCHAR(20),
    temperatura DECIMAL(4,2),
    peso DECIMAL(6,2),
    altura DECIMAL(5,2),
    FOREIGN KEY(id_paciente) REFERENCES pacientes(id_paciente) ON DELETE CASCADE,
    FOREIGN KEY(id_medico) REFERENCES medicos(id_medico) ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE calificaciones (
    id_calificacion INT AUTO_INCREMENT PRIMARY KEY,
    id_consulta INT NOT NULL,
    id_paciente INT NOT NULL,
    puntuacion INT CHECK (puntuacion >= 1 AND puntuacion <= 5),
    comentario TEXT,
    fecha_calificacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(id_consulta) REFERENCES consultas(id_consulta) ON DELETE CASCADE,
    FOREIGN KEY(id_paciente) REFERENCES pacientes(id_paciente) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    correo VARCHAR(100) NOT NULL UNIQUE, 
    password VARCHAR(255) NOT NULL,    
    rol VARCHAR(50) DEFAULT 'Recepcionista'
) ENGINE=InnoDB;

-- 3. Inserción de datos
INSERT INTO especialidades (nombre_especialidad, descripcion) VALUES  
('Cardiología', 'Prevención, diagnóstico y tratamiento de enfermedades del corazón.'),  
('Pediatría', 'Atención médica integral desde el nacimiento hasta la adolescencia.'),
('Dermatología', 'Diagnóstico y tratamiento de enfermedades de la piel, cabello y uñas.'),
('Odontología', 'Cuidado y tratamiento de la salud bucodental.'),
('Oftalmología', 'Cuidado de la visión y tratamiento de enfermedades oculares.');

INSERT INTO medicos (nombre_medico, id_especialidad, telefono) VALUES  
('Dr. Carlos Mendoza', 1, '555-0101'), 
('Dra. Sofía Martínez', 1, '555-0102'),   
('Dr. Juan Pablo Rivera', 2, '555-0103'),
('Dra. Valeria Benítez', 2, '555-0104'),
('Dr. Ricardo Fuentes', 3, '555-0105'),
('Dra. Camila Alvarado', 4, '555-0106'),
('Dr. Mauricio Castro', 4, '555-0107'),
('Dr. Roberto Cáceres', 5, '555-0108');

INSERT INTO pacientes (nombre_paciente, apellido_paciente, correo_paciente, telefono_paciente, fecha_nacimiento, genero, direccion, numero_identificacion, notas) VALUES
('Juan', 'García López', 'juan.garcia@email.com', '555-1001', '1985-03-15', 'Masculino', 'Calle 1 #100', '12345678A', 'Paciente hipertenso bajo control'),
('María', 'Rodríguez Pérez', 'maria.rodriguez@email.com', '555-1002', '1990-07-22', 'Femenino', 'Calle 2 #200', '12345678B', NULL),
('Carlos', 'Martínez Sánchez', 'carlos.martinez@email.com', '555-1003', '1988-11-30', 'Masculino', 'Calle 3 #300', '12345678C', 'Chequeos rutinarios de empresa'),
('Ana', 'Hernández González', 'ana.hernandez@email.com', '555-1004', '1992-01-10', 'Femenino', 'Calle 4 #400', '12345678D', NULL),
('Roberto', 'López Fernández', 'roberto.lopez@email.com', '555-1005', '1987-05-25', 'Masculino', 'Calle 5 #500', '12345678E', 'Alergia estacional severa'),
('Juana', 'Torres Ruiz', 'juana.torres@email.com', '555-1006', '1995-09-14', 'Femenino', 'Calle 6 #600', '12345678F', NULL),
('Pedro', 'Díaz Jiménez', 'pedro.diaz@email.com', '555-1007', '1989-02-18', 'Masculino', 'Calle 7 #700', '12345678G', NULL),
('Elena', 'Morales Castro', 'elena.morales@email.com', '555-1008', '1991-06-27', 'Femenino', 'Calle 8 #800', '12345678H', NULL),
('Miguel', 'Ramos Vega', 'miguel.ramos@email.com', '555-1009', '1986-10-12', 'Masculino', 'Calle 9 #900', '12345678I', NULL),
('Sofía', 'Navarro Romero', 'sofia.navarro@email.com', '555-1010', '1993-12-05', 'Femenino', 'Calle 10 #1000', '12345678J', 'Tratamiento ortodoncia activo');

INSERT INTO citas (id_paciente, id_medico, fecha_cita, hora_cita, estado, motivo_cita) VALUES  
(1, 1, '2026-05-15', '09:00:00', 'Completada', 'Revisión cardiaca'),
(2, 1, '2026-05-16', '10:00:00', 'Programada', 'Consulta inicial'),
(3, 2, '2026-05-15', '11:00:00', 'Completada', 'Revisión de presión'),
(4, 2, '2026-05-17', '14:00:00', 'Programada', 'Control de medicamentos'),
(5, 2, '2026-05-18', '15:00:00', 'Programada', 'Seguimiento'),
(6, 6, '2026-05-15', '09:30:00', 'Completada', 'Limpieza dental'),
(7, 6, '2026-05-16', '10:30:00', 'Completada', 'Revisión de caries'),
(8, 7, '2026-05-15', '11:30:00', 'Programada', 'Ortodoncia'),
(9, 7, '2026-05-17', '13:00:00', 'Programada', 'Consulta inicial'),
(10, 3, '2026-05-16', '09:15:00', 'Completada', 'Examen pediátrico'),
(1, 3, '2026-05-18', '10:15:00', 'Programada', 'Seguimiento'),
(2, 4, '2026-05-15', '14:30:00', 'Programada', 'Vacunas'),
(3, 5, '2026-05-16', '15:30:00', 'Completada', 'Dermatitis'),
(4, 5, '2026-05-19', '09:00:00', 'Programada', 'Acné'),
(5, 8, '2026-05-16', '16:00:00', 'Completada', 'Examen oftalmológico');

INSERT INTO consultas (id_paciente, id_medico, diagnóstico, tratamiento, observaciones, presión_arterial, temperatura, peso, altura) VALUES
(1, 1, 'Hipertensión moderada', 'Enalapril 10mg diarios', 'Paciente con antecedentes familiares', '150/95', 36.8, 75.5, 1.80),
(2, 1, 'Arritmia cardíaca leve', 'Betabloqueador + seguimiento', 'Requiere ECG mensual', '140/85', 36.9, 65.0, 1.65),
(3, 2, 'Presión arterial normal', 'Dieta baja en sodio', 'Sin medicamentos necesarios', '120/80', 37.0, 70.0, 1.75),
(6, 6, 'Caries dental', 'Obturación con composite', 'Pieza 16 afectada', NULL, 36.8, 58.0, 1.60),
(7, 6, 'Placa bacteriana', 'Limpieza profesional + instrucción oral', 'Mejorar higiene', NULL, 36.7, 62.0, 1.72),
(10, 3, 'Otitis media', 'Amoxicilina 500mg x 7 días', 'Revisión en 1 semana', '105/65', 38.2, 25.0, 1.15),
(4, 5, 'Dermatitis atópica', 'Crema hidratante + corticoide leve', 'Evitar irritantes', NULL, 36.8, 72.0, 1.78),
(5, 8, 'Miopía moderada', 'Prescripción: -2.50 DE', 'Gafas recomendadas', NULL, 36.9, 80.0, 1.82);

INSERT INTO calificaciones (id_consulta, id_paciente, puntuacion, comentario) VALUES
(1, 1, 5, 'Excelente atención, muy profesional el Dr. Mendoza'),
(2, 2, 4, 'Buena consulta, pero esperé mucho tiempo'),
(3, 3, 5, 'Muy satisfecho con la atención recibida'),
(4, 6, 5, 'Dra. Alvarado muy atenta y precisa'),
(5, 7, 4, 'Buena atención, consultorio limpio'),
(6, 10, 5, 'El Dr. Rivera fue muy dedicado con mi hijo'),
(7, 4, 4, 'Buen diagnóstico pero caro el tratamiento'),
(8, 5, 5, 'Excelente diagnóstico y recomendaciones');

INSERT INTO usuarios (username, correo, password, rol) VALUES 
('admin', 'admin@gmail.com', '$2y$10$fWJ0EIKFomVfH7bWj13eUeMv8Z9X7fWJ0EIKFomVfH7bWj13eUeMv', 'Admin');