-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-06-2026 a las 22:59:04
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
-- Base de datos: `revistas_delfin`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `revistas`
--

CREATE TABLE `revistas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(300) NOT NULL,
  `area` varchar(200) DEFAULT NULL,
  `pais` varchar(100) DEFAULT NULL,
  `cuartil_sjr` enum('Q1','Q2','Q3','Q4','N/A') DEFAULT 'N/A',
  `cuartil_jcr` enum('Q1','Q2','Q3','Q4','N/A') DEFAULT 'N/A',
  `apc_tipo` enum('gratuita','pago','hibrida') DEFAULT 'gratuita',
  `apc_descripcion` varchar(250) DEFAULT NULL,
  `indexaciones` varchar(300) DEFAULT NULL,
  `editorial` varchar(200) DEFAULT NULL,
  `idiomas` varchar(150) DEFAULT NULL,
  `tipos_articulos` varchar(300) DEFAULT NULL,
  `acceso` enum('abierto','suscripcion','hibrido') DEFAULT 'abierto',
  `confiabilidad` tinyint(3) UNSIGNED DEFAULT NULL CHECK (`confiabilidad` between 1 and 5),
  `recomendada_estudiantes` tinyint(3) UNSIGNED DEFAULT NULL CHECK (`recomendada_estudiantes` between 1 and 5),
  `descripcion` text DEFAULT NULL,
  `sitio_web` varchar(500) DEFAULT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `revistas`
--
ALTER TABLE `revistas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_cuartil_sjr` (`cuartil_sjr`),
  ADD KEY `idx_cuartil_jcr` (`cuartil_jcr`),
  ADD KEY `idx_apc_tipo` (`apc_tipo`),
  ADD KEY `idx_acceso` (`acceso`),
  ADD KEY `idx_confiabilidad` (`confiabilidad`),
  ADD KEY `idx_recomendada_estudiantes` (`recomendada_estudiantes`),
  ADD KEY `idx_pais` (`pais`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `revistas`
--
ALTER TABLE `revistas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
