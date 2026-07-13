-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 13-07-2026 a las 14:52:41
-- Versión del servidor: 11.8.8-MariaDB-log
-- Versión de PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `u583236171_rev`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `nombre_usuario` varchar(20) NOT NULL,
  `contrasena` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`nombre_usuario`, `contrasena`) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `indexaciones`
--

CREATE TABLE `indexaciones` (
  `id` int(11) NOT NULL,
  `indexacion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `revistas`
--

CREATE TABLE `revistas` (
  `id` int(11) NOT NULL,
  `titulo_revista` varchar(300) NOT NULL,
  `id_tema` int(11) NOT NULL,
  `cuartil` enum('Q1','Q2','Q3','Q4','SIN ASIGNAR') NOT NULL DEFAULT 'SIN ASIGNAR',
  `idioma` enum('Espanol','Ingles','Portugues','Frances','Otro') NOT NULL,
  `costo` decimal(10,2) NOT NULL DEFAULT 0.00,
  `open_access` tinyint(1) NOT NULL DEFAULT 0,
  `arbitrada` tinyint(1) NOT NULL DEFAULT 0,
  `descripcion` text NOT NULL,
  `enlace` varchar(2083) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `revista_indexacion`
--

CREATE TABLE `revista_indexacion` (
  `id_revista` int(11) NOT NULL,
  `id_indexacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `revista_tema`
--

CREATE TABLE `revista_tema` (
  `id_revista` int(11) NOT NULL,
  `id_tema` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sugerencias`
--

CREATE TABLE `sugerencias` (
  `id` int(11) NOT NULL,
  `tipo_problema` enum('Revista','Comentario','Problema') NOT NULL,
  `nombre` varchar(80) NOT NULL,
  `enlace` varchar(200) DEFAULT '',
  `detalles` text NOT NULL,
  `fecha_envio` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `temas`
--

CREATE TABLE `temas` (
  `id` int(11) NOT NULL,
  `tema` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_revistas`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_revistas` (
`id` int(11)
,`titulo_revista` varchar(300)
,`cuartil` enum('Q1','Q2','Q3','Q4','SIN ASIGNAR')
,`idioma` enum('Espanol','Ingles','Portugues','Frances','Otro')
,`costo` decimal(10,2)
,`open_access` tinyint(1)
,`arbitrada` tinyint(1)
,`descripcion` text
,`enlace` varchar(2083)
,`tema_principal` varchar(100)
,`todos_temas` longtext
,`indexaciones` longtext
);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`nombre_usuario`);

--
-- Indices de la tabla `indexaciones`
--
ALTER TABLE `indexaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `revistas`
--
ALTER TABLE `revistas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_tema` (`id_tema`);

--
-- Indices de la tabla `revista_indexacion`
--
ALTER TABLE `revista_indexacion`
  ADD PRIMARY KEY (`id_revista`,`id_indexacion`),
  ADD KEY `id_indexacion` (`id_indexacion`);

--
-- Indices de la tabla `revista_tema`
--
ALTER TABLE `revista_tema`
  ADD PRIMARY KEY (`id_revista`,`id_tema`),
  ADD KEY `id_tema` (`id_tema`);

--
-- Indices de la tabla `sugerencias`
--
ALTER TABLE `sugerencias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `temas`
--
ALTER TABLE `temas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tema` (`tema`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `indexaciones`
--
ALTER TABLE `indexaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `revistas`
--
ALTER TABLE `revistas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sugerencias`
--
ALTER TABLE `sugerencias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `temas`
--
ALTER TABLE `temas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_revistas`
--
DROP TABLE IF EXISTS `vista_revistas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`u583236171_rev`@`127.0.0.1` SQL SECURITY DEFINER VIEW `vista_revistas`  AS SELECT `r`.`id` AS `id`, `r`.`titulo_revista` AS `titulo_revista`, `r`.`cuartil` AS `cuartil`, `r`.`idioma` AS `idioma`, `r`.`costo` AS `costo`, `r`.`open_access` AS `open_access`, `r`.`arbitrada` AS `arbitrada`, `r`.`descripcion` AS `descripcion`, `r`.`enlace` AS `enlace`, `t`.`tema` AS `tema_principal`, group_concat(distinct `t2`.`tema` order by `t2`.`tema` ASC separator ', ') AS `todos_temas`, group_concat(distinct `i`.`indexacion` order by `i`.`indexacion` ASC separator ', ') AS `indexaciones` FROM (((((`revistas` `r` left join `temas` `t` on(`t`.`id` = `r`.`id_tema`)) left join `revista_tema` `rt` on(`rt`.`id_revista` = `r`.`id`)) left join `temas` `t2` on(`t2`.`id` = `rt`.`id_tema`)) left join `revista_indexacion` `ri` on(`ri`.`id_revista` = `r`.`id`)) left join `indexaciones` `i` on(`i`.`id` = `ri`.`id_indexacion`)) GROUP BY `r`.`id` ;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `revistas`
--
ALTER TABLE `revistas`
  ADD CONSTRAINT `revistas_ibfk_1` FOREIGN KEY (`id_tema`) REFERENCES `temas` (`id`);

--
-- Filtros para la tabla `revista_indexacion`
--
ALTER TABLE `revista_indexacion`
  ADD CONSTRAINT `revista_indexacion_ibfk_1` FOREIGN KEY (`id_revista`) REFERENCES `revistas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `revista_indexacion_ibfk_2` FOREIGN KEY (`id_indexacion`) REFERENCES `indexaciones` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `revista_tema`
--
ALTER TABLE `revista_tema`
  ADD CONSTRAINT `revista_tema_ibfk_1` FOREIGN KEY (`id_revista`) REFERENCES `revistas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `revista_tema_ibfk_2` FOREIGN KEY (`id_tema`) REFERENCES `temas` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
