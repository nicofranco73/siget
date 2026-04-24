-- schema.sql
-- Base de datos: siget
-- Motor: InnoDB, charset utf8mb4

CREATE DATABASE IF NOT EXISTS siget CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE siget;

-- Tabla pacientes
CREATE TABLE IF NOT EXISTS pacientes (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  apellido VARCHAR(100) NOT NULL,
  dni VARCHAR(20) NOT NULL UNIQUE,
  fecha_nac DATE DEFAULT NULL,
  telefono VARCHAR(50) DEFAULT NULL,
  email VARCHAR(150) DEFAULT NULL,
  direccion VARCHAR(255) DEFAULT NULL,
  creado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  actualizado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  activo TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla profesionales
CREATE TABLE IF NOT EXISTS profesionales (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  apellido VARCHAR(100) NOT NULL,
  especialidad VARCHAR(100) DEFAULT NULL,
  telefono VARCHAR(50) DEFAULT NULL,
  email VARCHAR(150) DEFAULT NULL,
  disponibilidad JSON DEFAULT NULL,
  creado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  actualizado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  activo TINYINT(1) NOT NULL DEFAULT 1,
  UNIQUE KEY uk_prof_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla usuarios (administradores simples)
CREATE TABLE IF NOT EXISTS usuarios (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  nombre VARCHAR(150) DEFAULT NULL,
  rol VARCHAR(50) DEFAULT 'admin',
  creado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  activo TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla turnos
CREATE TABLE IF NOT EXISTS turnos (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  paciente_id INT UNSIGNED NOT NULL,
  profesional_id INT UNSIGNED NOT NULL,
  fecha_hora_inicio DATETIME NOT NULL,
  fecha_hora_fin DATETIME NOT NULL,
  estado ENUM('programado','atendido','cancelado') NOT NULL DEFAULT 'programado',
  motivo TEXT DEFAULT NULL,
  creado_por INT UNSIGNED DEFAULT NULL,
  cancelado_por INT UNSIGNED DEFAULT NULL,
  motivo_cancelacion TEXT DEFAULT NULL,
  creado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  actualizado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  activo TINYINT(1) NOT NULL DEFAULT 1,
  INDEX idx_turnos_fecha (fecha_hora_inicio),
  INDEX idx_turnos_prof (profesional_id),
  CONSTRAINT fk_turno_paciente FOREIGN KEY (paciente_id) REFERENCES pacientes(id) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT fk_turno_profesional FOREIGN KEY (profesional_id) REFERENCES profesionales(id) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT fk_turno_creado_por FOREIGN KEY (creado_por) REFERENCES usuarios(id) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT fk_turno_cancelado_por FOREIGN KEY (cancelado_por) REFERENCES usuarios(id) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Datos de ejemplo (opcionales)
INSERT INTO pacientes (nombre, apellido, dni, fecha_nac, telefono, email, direccion) VALUES
('María','González','30111222','1985-03-10','1133344455','maria.g@example.com','Calle Falsa 123'),
('Juan','Pérez','27123456','1990-07-22','1144455566','juan.p@example.com','Av. Siempre Viva 742'),
('Ana','López','32999888','1978-01-05','1155566677','ana.l@example.com','Calle Real 50');

INSERT INTO profesionales (nombre, apellido, especialidad, telefono, email, disponibilidad) VALUES
('Martín','Gómez','Cardiología','1166677788','martin.cardio@example.com', JSON_ARRAY('LUN:08:00-17:00','MAR:08:00-17:00','MIE:08:00-12:00')),
('Silvia','Ramírez','Pediatría','1167788990','silvia.pedi@example.com', JSON_ARRAY('LUN:09:00-15:00','JUE:08:00-17:00','VIE:08:00-13:00'));

-- Turnos de ejemplo (30 minutos)
INSERT INTO turnos (paciente_id, profesional_id, fecha_hora_inicio, fecha_hora_fin, estado, motivo, creado_por) VALUES
(1,1,'2026-01-21 09:00:00','2026-01-21 09:30:00','programado','Control anual',NULL),
(2,1,'2026-01-21 10:00:00','2026-01-21 10:30:00','programado','Consulta por dolor',NULL),
(3,2,'2026-01-22 09:30:00','2026-01-22 10:00:00','programado','Vacunación',NULL);

-- NOTA:
-- No se inserta aquí el usuario admin por seguridad.
-- Después de importar, podés crear el admin en phpMyAdmin o con:
-- INSERT INTO usuarios (username, password_hash, nombre, rol) VALUES ('admin', 'EL_HASH_GENERADO', 'Administrador', 'admin');
-- Generar EL_HASH_GENERADO con PHP: php -r "echo password_hash('TuPass', PASSWORD_DEFAULT).PHP_EOL;"