-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-05-2023 a las 19:21:25
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
  `campania` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id`, `descripcion`, `color`, `campania`) VALUES
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
-- Estructura de tabla para la tabla `genero`
--

DROP TABLE IF EXISTS `genero`;
CREATE TABLE `genero` (
  `generoId` int(11) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `genero`
--

INSERT INTO `genero` (`generoId`, `descripcion`) VALUES
(1, 'Masculino'),
(2, 'Femenino'),
(3, 'Prefiero no cargarlo');

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
  `cantidadDeReportes` int(11) NOT NULL,
  `dificultad` int(2) NOT NULL DEFAULT 50
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pregunta`
--

INSERT INTO `pregunta` (`id`, `descripcion`, `categoria`, `cantidadDeReportes`, `dificultad`) VALUES
(1, 'el cielo de que color es?', 1, 0, 50);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roll`
--

DROP TABLE IF EXISTS `roll`;
CREATE TABLE `roll` (
  `rollId` int(11) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roll`
--

INSERT INTO `roll` (`rollId`, `descripcion`) VALUES
(1, 'administrador'),
(2, 'editor'),
(3, 'jugador');

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
  `activo` tinyint(1) NOT NULL DEFAULT 0,
  `nombreUsuario` varchar(100) NOT NULL,
  `f_nacimiento` date DEFAULT NULL,
  `generoId` int(11) DEFAULT NULL,
  `f_registro` timestamp NULL DEFAULT current_timestamp(),
  `fotoPerfil` varchar(150) DEFAULT NULL,
  `roll` int(1) NOT NULL DEFAULT 3,
  `dificultad` int(2) NOT NULL DEFAULT 50
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `apellido`, `correo`, `password`, `activo`, `nombreUsuario`, `f_nacimiento`, `generoId`, `f_registro`, `fotoPerfil`, `roll`, `dificultad`) VALUES
(19, 'usuario', 'usuario', 'usuario@usuario.com', 'f8032d5cae3de20fcec887f395ec9a6a', 1, 'usuario', '1991-01-01', 1, '0000-00-00 00:00:00', 'usuario.png', 1, 50),
(20, 'editor', 'editor', 'editor@editor.com', '5aee9dbd2a188839105073571bee1b1f', 1, 'editor', '1990-01-01', 1, '0000-00-00 00:00:00', 'editor.png', 2, 50),
(21, 'admin', 'admin', 'admin@admin.com', '21232f297a57a5a743894a0e4a801fc3', 1, 'admin', '1991-01-01', 1, '0000-00-00 00:00:00', 'admin.png', 3, 50),
(22, 'usuario1', 'usuario1', 'usuario1@usuario1.com', '122b738600a0f74f7c331c0ef59bc34c', 1, 'usuario1', '1991-10-01', 2, '0000-00-00 00:00:00', 'usuario1.png', 1, 50),
(25, 'gab', 'gab', 'gabirel@live.com', '639bee393eecbc62256936a8e64d17b1', 1, 'gab', '1991-01-01', 1, '2023-05-30 09:55:32', 'gab.png', 3, 50);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `genero`
--
ALTER TABLE `genero`
  ADD PRIMARY KEY (`generoId`);

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
-- Indices de la tabla `roll`
--
ALTER TABLE `roll`
  ADD PRIMARY KEY (`rollId`);

--
-- Indices de la tabla `top10`
--
ALTER TABLE `top10`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `generoId` (`generoId`),
  ADD KEY `roll` (`roll`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `genero`
--
ALTER TABLE `genero`
  MODIFY `generoId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
-- AUTO_INCREMENT de la tabla `roll`
--
ALTER TABLE `roll`
  MODIFY `rollId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `top10`
--
ALTER TABLE `top10`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

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

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `generoId` FOREIGN KEY (`generoId`) REFERENCES `genero` (`generoId`),
  ADD CONSTRAINT `roll` FOREIGN KEY (`roll`) REFERENCES `roll` (`rollId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
