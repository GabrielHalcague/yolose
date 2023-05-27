-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-05-2023 a las 20:07:12
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.2.0

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
CREATE DATABASE IF NOT EXISTS yolose;
use yolose;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

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
-- Estructura de tabla para la tabla `genero`
--

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
-- Estructura de tabla para la tabla `roll`
--

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
-- Estructura de tabla para la tabla `rollusuario`
--

CREATE TABLE `rollusuario` (
                               `rollUsuarioId` int(11) NOT NULL,
                               `usuarioId` int(11) DEFAULT NULL,
                               `rollId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `top10`
--

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

CREATE TABLE `usuario` (
                           `id` int(11) NOT NULL,
                           `nombre` varchar(50) NOT NULL,
                           `apellido` varchar(50) NOT NULL,
                           `correo` varchar(150) NOT NULL,
                           `password` varchar(50) NOT NULL,
                           `activo` tinyint(1) NOT NULL DEFAULT 0,
                           `nombreUsuario` varchar(100) DEFAULT NULL,
                           `f_nacimiento` date DEFAULT NULL,
                           `generoId` int(11) DEFAULT NULL,
                           `f_registro` date DEFAULT curdate(),
                           `fotoPerfil` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `apellido`, `correo`, `password`, `activo`, `nombreUsuario`, `f_nacimiento`, `generoId`, `f_registro`, `fotoPerfil`) VALUES
                                                                                                                                                                (13, 'Sebastian', 'Pereyra', 'pepe@ganic.com', '202cb962ac59075b964b07152d234b70', 0, 'usuario1', '1980-02-12', 3, '2023-05-23', NULL),
                                                                                                                                                                (14, 'cristian', 'feldman', 'cris@gmail.com', '202cb962ac59075b964b07152d234b70', 0, 'cris', '1998-06-25', 2, '2023-05-23', NULL),
                                                                                                                                                                (16, 'Jaime', 'jaimeApellido', 'jaime@gmail.com', '202cb962ac59075b964b07152d234b70', 0, 'jaimeUser', '1985-02-11', 3, '2023-05-24', NULL),
                                                                                                                                                                (17, 'usuario4', 'usuario4', 'usuario4@gmail.com', '202cb962ac59075b964b07152d234b70', 0, 'usuario4', '2000-02-21', 2, '2023-05-24', NULL),
                                                                                                                                                                (18, 'usuario5', 'usuario5', 'usuario5@gmail.com', '202cb962ac59075b964b07152d234b70', 0, 'usuario5', '1995-02-02', 2, '2023-05-24', NULL);

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
-- Indices de la tabla `rollusuario`
--
ALTER TABLE `rollusuario`
    ADD PRIMARY KEY (`rollUsuarioId`),
  ADD KEY `usuarioId` (`usuarioId`),
  ADD KEY `rollUsuario` (`rollId`);

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
  ADD KEY `generoId` (`generoId`);

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
-- AUTO_INCREMENT de la tabla `rollusuario`
--
ALTER TABLE `rollusuario`
    MODIFY `rollUsuarioId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `top10`
--
ALTER TABLE `top10`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

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
-- Filtros para la tabla `rollusuario`
--
ALTER TABLE `rollusuario`
    ADD CONSTRAINT `rollUsuario` FOREIGN KEY (`rollId`) REFERENCES `roll` (`rollId`),
  ADD CONSTRAINT `usuarioId` FOREIGN KEY (`usuarioId`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
    ADD CONSTRAINT `generoId` FOREIGN KEY (`generoId`) REFERENCES `genero` (`generoId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
