-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-05-2023 a las 20:45:39
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `yolose`
--
CREATE DATABASE IF NOT EXISTS `yolose` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `yolose`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

DROP TABLE IF EXISTS `categoria`;
CREATE TABLE `categoria` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(20) NOT NULL,
  `color` varchar(20) NOT NULL,
  `campaña` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id`, `descripcion`, `color`, `campaña`) VALUES
(1, 'Geografía', 'brown', ''),
(2, 'Geografía', 'brown', ''),
(3, 'Ciencia', 'Purple', ''),
(4, 'Historia', 'Light Blue', ''),
(5, 'Deporte', 'Khaki', ''),
(6, 'Arte', 'Blue Gray', ''),
(7, 'Entretenimiento', 'Pale Green', ''),
(8, 'Peliculas', 'Pale Yellow', ''),
(9, 'Galicia', 'orange', 'Galicia'),
(10, 'Unlam', 'green', 'Unlam');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opcion`
--

DROP TABLE IF EXISTS `opcion`;
CREATE TABLE `opcion` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `verdadero` tinyint(1) NOT NULL,
  `idPregunta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `opcion`
--

INSERT INTO `opcion` (`id`, `descripcion`, `verdadero`, `idPregunta`) VALUES
(11, 'rojo', 0, 1),
(12, 'azul', 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta`
--

DROP TABLE IF EXISTS `pregunta`;
CREATE TABLE `pregunta` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `categoria` int(11) NOT NULL,
  `cantidadDeReportes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pregunta`
--

INSERT INTO `pregunta` (`id`, `descripcion`, `categoria`, `cantidadDeReportes`) VALUES
(1, 'el cielo de que color es?', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `top10`
--

DROP TABLE IF EXISTS `top10`;
CREATE TABLE `top10` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `puntos` int(11) NOT NULL,
  `tipodepartida` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `top10`
--

INSERT INTO `top10` (`id`, `usuario`, `puntos`, `tipodepartida`) VALUES
(1, 'pepe', 110, 1),
(2, 'manuel', 50, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `password` varchar(50) NOT NULL,
  `rol` smallint(6) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 0,
  `puntos` int(11) NOT NULL,
  `trampas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `apellido`, `correo`, `password`, `rol`, `activo`, `puntos`, `trampas`) VALUES
(1, 'pepe', 'gomez', 'asd@live.com', 'asd', 1, 0, 150, 10),
(3, 'usuario', 'usuario', 'usuario@usuario.com', 'usuario', 1, 1, 100, 10),
(4, 'usuario', 'usuario', 'usuario@usuario.com', 'usuario', 1, 1, 100, 10),
(5, 'usuario2', 'usuario2', 'usuario2@usuario2.com', 'usuario2', 1, 0, 100, 10),
(6, 'editor', 'editor', 'editor@editor.com', 'editor', 2, 1, 0, 0),
(7, 'admin', 'admin', 'admin@admin.com', 'admin', 3, 1, 0, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `opcion`
--
ALTER TABLE `opcion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idPregunta` (`idPregunta`);

--
-- Indices de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoria` (`categoria`);

--
-- Indices de la tabla `top10`
--
ALTER TABLE `top10`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `opcion`
--
ALTER TABLE `opcion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `top10`
--
ALTER TABLE `top10`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `opcion`
--
ALTER TABLE `opcion`
  ADD CONSTRAINT `idPregunta` FOREIGN KEY (`idPregunta`) REFERENCES `pregunta` (`id`);

--
-- Filtros para la tabla `pregunta`
--
ALTER TABLE `pregunta`
  ADD CONSTRAINT `categoria` FOREIGN KEY (`categoria`) REFERENCES `categoria` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
