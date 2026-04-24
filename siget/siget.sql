-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-01-2026 a las 05:47:33
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `siget`
--
CREATE DATABASE IF NOT EXISTS `siget` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `siget`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pacientes`
--

DROP TABLE IF EXISTS `pacientes`;
CREATE TABLE IF NOT EXISTS `pacientes` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `dni` varchar(20) NOT NULL,
  `fecha_nac` date DEFAULT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp(),
  `actualizado_en` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dni` (`dni`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pacientes`
--

INSERT INTO `pacientes` (`id`, `nombre`, `apellido`, `dni`, `fecha_nac`, `telefono`, `email`, `direccion`, `creado_en`, `actualizado_en`, `activo`) VALUES
(1, 'María', 'González', '30111222', '1985-03-10', '1133344455', 'maria.g@example.com', 'Calle Falsa 123', '2026-01-19 05:00:15', '2026-01-19 05:00:15', 1),
(2, 'Juan', 'Pérez', '27123456', '1990-07-22', '1144455566', 'juan.p@example.com', 'Av. Siempre Viva 742', '2026-01-19 05:00:15', '2026-01-19 05:00:15', 1),
(3, 'Ana', 'López', '32999888', '1978-01-05', '1155566677', 'ana.l@example.com', 'Calle Real 50', '2026-01-19 05:00:15', '2026-01-19 05:00:15', 1),
(4, 'nicolas', 'franco', '40005463', '1996-11-19', '3751503904', 'nicolasfranco416@gmail.com', 'calle mojon grande barrio alta tension s/n', '2026-01-19 05:40:12', '2026-01-19 05:40:12', 1),
(5, 'rollo', 'franco', '232322323', NULL, '2323232322', 'fakuufranco18@gmail.com', NULL, '2026-01-19 17:28:44', '2026-01-19 17:28:44', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesionales`
--

DROP TABLE IF EXISTS `profesionales`;
CREATE TABLE IF NOT EXISTS `profesionales` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `especialidad` varchar(100) DEFAULT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `disponibilidad` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`disponibilidad`)),
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp(),
  `actualizado_en` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_prof_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `profesionales`
--

INSERT INTO `profesionales` (`id`, `nombre`, `apellido`, `especialidad`, `telefono`, `email`, `disponibilidad`, `creado_en`, `actualizado_en`, `activo`) VALUES
(1, 'Martín', 'Gómez', 'Cardiología', '1166677788', 'martin.cardio@example.com', '[\"LUN:08:00-17:00\", \"MAR:08:00-17:00\", \"MIE:08:00-12:00\"]', '2026-01-19 05:00:15', '2026-01-19 05:00:15', 1),
(2, 'Silvia', 'Ramírez', 'Pediatría', '1167788990', 'silvia.pedi@example.com', '[\"LUN:09:00-15:00\", \"JUE:08:00-17:00\", \"VIE:08:00-13:00\"]', '2026-01-19 05:00:15', '2026-01-19 05:00:15', 1),
(3, 'jonathan', 'franco', 'ginecologo', '3751503904', 'nicolasfranco416@gmail.com', '[\"LUN:08:00-17:00\",\"MAR:08:00-12:00\",\"MIE:08:00-12:00\"]', '2026-01-19 05:51:43', '2026-01-19 05:51:43', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `turnos`
--

DROP TABLE IF EXISTS `turnos`;
CREATE TABLE IF NOT EXISTS `turnos` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `paciente_id` int(10) UNSIGNED NOT NULL,
  `profesional_id` int(10) UNSIGNED NOT NULL,
  `fecha_hora_inicio` datetime NOT NULL,
  `fecha_hora_fin` datetime NOT NULL,
  `estado` enum('programado','atendido','cancelado') NOT NULL DEFAULT 'programado',
  `motivo` text DEFAULT NULL,
  `creado_por` int(10) UNSIGNED DEFAULT NULL,
  `cancelado_por` int(10) UNSIGNED DEFAULT NULL,
  `motivo_cancelacion` text DEFAULT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp(),
  `actualizado_en` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `inicio` datetime DEFAULT NULL,
  `duracion_min` int(11) NOT NULL DEFAULT 30,
  PRIMARY KEY (`id`),
  KEY `idx_turnos_fecha` (`fecha_hora_inicio`),
  KEY `idx_turnos_prof` (`profesional_id`),
  KEY `fk_turno_paciente` (`paciente_id`),
  KEY `fk_turno_creado_por` (`creado_por`),
  KEY `fk_turno_cancelado_por` (`cancelado_por`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `turnos`
--

INSERT INTO `turnos` (`id`, `paciente_id`, `profesional_id`, `fecha_hora_inicio`, `fecha_hora_fin`, `estado`, `motivo`, `creado_por`, `cancelado_por`, `motivo_cancelacion`, `creado_en`, `actualizado_en`, `activo`, `inicio`, `duracion_min`) VALUES
(1, 1, 1, '2026-01-21 09:00:00', '2026-01-21 09:30:00', 'programado', 'Control anual', NULL, NULL, NULL, '2026-01-19 05:00:15', '2026-01-19 05:00:15', 1, NULL, 30),
(2, 2, 1, '2026-01-21 10:00:00', '2026-01-21 10:30:00', 'programado', 'Consulta por dolor', NULL, NULL, NULL, '2026-01-19 05:00:15', '2026-01-19 05:00:15', 1, NULL, 30),
(3, 3, 2, '2026-01-22 09:30:00', '2026-01-22 10:00:00', 'programado', 'Vacunación', NULL, NULL, NULL, '2026-01-19 05:00:15', '2026-01-19 05:00:15', 1, NULL, 30),
(4, 1, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'cancelado', 'se la metieron duro', NULL, NULL, NULL, '2026-01-19 06:23:03', '2026-01-26 00:02:28', 1, '2026-01-29 03:25:00', 30),
(5, 1, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'programado', 'se la metieron duro', NULL, NULL, NULL, '2026-01-19 17:29:23', '2026-01-19 17:29:23', 1, '2026-01-16 14:29:00', 30);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `nombre` varchar(150) DEFAULT NULL,
  `rol` varchar(50) DEFAULT 'admin',
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp(),
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `turnos`
--
ALTER TABLE `turnos`
  ADD CONSTRAINT `fk_turno_cancelado_por` FOREIGN KEY (`cancelado_por`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_turno_creado_por` FOREIGN KEY (`creado_por`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_turno_paciente` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_turno_profesional` FOREIGN KEY (`profesional_id`) REFERENCES `profesionales` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
