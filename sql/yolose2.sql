-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-06-2023 a las 00:49:58
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
-- Base de datos: `yolose2`
--
CREATE DATABASE IF NOT EXISTS `yolose2` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `yolose2`;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `cantidadusuariosporgenero`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `cantidadusuariosporgenero`;
CREATE TABLE IF NOT EXISTS `cantidadusuariosporgenero` (
`sexo` varchar(15)
,`cantidad` bigint(21)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

DROP TABLE IF EXISTS `categoria`;
CREATE TABLE IF NOT EXISTS `categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categ` varchar(50) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id`, `categ`, `color`) VALUES
                                                     (1, 'Geografía', 'blue'),
                                                     (2, 'Ciencia', 'brown'),
                                                     (3, 'Historia', 'purple'),
                                                     (4, 'Deporte', 'green'),
                                                     (5, 'Tecnologia', 'blueviolet'),
                                                     (6, 'Entretenimiento', 'orange'),
                                                     (7, 'Peliculas', 'turquoise');


-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `dificultaddificil`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `dificultaddificil`;
CREATE TABLE IF NOT EXISTS `dificultaddificil` (
`preguntaID` int(11)
,`pregunta` varchar(500)
,`respuestaCorrecta` int(11)
,`color` varchar(50)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `dificultadfacil`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `dificultadfacil`;
CREATE TABLE IF NOT EXISTS `dificultadfacil` (
`preguntaID` int(11)
,`pregunta` varchar(500)
,`respuestaCorrecta` int(11)
,`color` varchar(50)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `dificultadmedia`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `dificultadmedia`;
CREATE TABLE IF NOT EXISTS `dificultadmedia` (
`preguntaID` int(11)
,`pregunta` varchar(500)
,`respuestaCorrecta` int(11)
,`color` varchar(50)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `dificultadusuario`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `dificultadusuario`;
CREATE TABLE IF NOT EXISTS `dificultadusuario` (
`idUs` int(11)
,`dificultad` decimal(27,4)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

DROP TABLE IF EXISTS `estado`;
CREATE TABLE IF NOT EXISTS `estado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descr` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`id`, `descr`) VALUES
(1, 'PENDIENTE APROBACIÓN'),
(2, 'REPORTADO'),
(3, 'ELIMINADO'),
(4, 'ACTIVO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `genero`
--

DROP TABLE IF EXISTS `genero`;
CREATE TABLE IF NOT EXISTS `genero` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descr` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `genero`
--

INSERT INTO `genero` (`id`, `descr`) VALUES
(1, 'Masculino'),
(2, 'Femenino'),
(3, 'Prefiero no Cargarlo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historialcompras`
--

DROP TABLE IF EXISTS `historialcompras`;
CREATE TABLE IF NOT EXISTS `historialcompras` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `f_compra` date DEFAULT curdate(),
  `cant` int(11) DEFAULT NULL,
  `idUs` int(11) DEFAULT NULL,
  `idTr` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_HistorialCompras_Usuario` (`idUs`),
  KEY `FK_HistorialCompras_Trampas` (`idTr`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historialcompras`
--

INSERT INTO `historialcompras` (`id`, `f_compra`, `cant`, `idUs`, `idTr`) VALUES
(1, '2023-06-14', 5, 3, 1),
(2, '2023-06-14', 5, 1, 1),
(3, '2023-06-17', 5, 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historialpartidas`
--

DROP TABLE IF EXISTS `historialpartidas`;
CREATE TABLE IF NOT EXISTS `historialpartidas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `f_partida` date DEFAULT curdate(),
  `estado` tinyint(1) DEFAULT 0,
  `n_partida` varchar(50) DEFAULT NULL,
  `idUs` int(11) DEFAULT NULL,
  `idPreg` int(11) DEFAULT NULL,
  `tipoPartida` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_HistorialPartida_Usuario` (`idUs`),
  KEY `FK_HistorialPartida_Pregunta` (`idPreg`),
  KEY `Fk_historialPartida_tipoPartida` (`tipoPartida`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historialpartidas`
--

INSERT INTO `historialpartidas` (`id`, `f_partida`, `estado`, `n_partida`, `idUs`, `idPreg`, `tipoPartida`) VALUES
(1, '2023-06-10', 0, '64848f3f787e9', 2, 25, 1),
(2, '2023-06-10', 0, '648493954575c', 2, 23, 1),
(3, '2023-06-10', 1, '648493954575c', 2, 22, 1),
(4, '2023-06-10', 1, '648493954575c', 2, 24, 1),
(5, '2023-06-10', 0, '648493954575c', 2, 14, 1),
(6, '2023-06-10', 0, '648497f431e68', 2, 13, 1),
(7, '2023-06-10', 1, '648497f431e68', 2, 15, 1),
(8, '2023-06-10', 0, '648497f431e68', 2, 12, 1),
(9, '2023-06-10', 1, '648497f431e68', 2, 17, 1),
(10, '2023-06-10', 0, '648497f431e68', 2, 11, 1),
(11, '2023-06-10', 0, '648497f431e68', 2, 16, 1),
(12, '2023-06-10', 0, '648497f431e68', 2, 18, 1),
(13, '2023-06-10', 0, '648497f431e68', 2, 20, 1),
(14, '2023-06-10', 0, '648497f431e68', 2, 19, 1),
(15, '2023-06-10', 0, '64849b83bbdbd', 2, 28, 1),
(16, '2023-06-10', 0, '64849b83bbdbd', 2, 26, 1),
(17, '2023-06-10', 0, '64849b83bbdbd', 2, 27, 1),
(18, '2023-06-10', 0, '64849b83bbdbd', 2, 29, 1),
(19, '2023-06-10', 0, '64849b83bbdbd', 2, 21, 1),
(20, '2023-06-10', 1, '64849ea8cbd11', 2, 30, 1),
(21, '2023-06-10', 0, '64849ea8cbd11', 2, 31, 1),
(22, '2023-06-10', 0, '64849ea8cbd11', 2, 24, 1),
(23, '2023-06-10', 1, '6484a01853502', 2, 22, 1),
(24, '2023-06-10', 0, '6484a01853502', 2, 25, 1),
(25, '2023-06-10', 0, '6484a01853502', 2, 21, 1),
(26, '2023-06-10', 0, '6484a01853502', 2, 23, 1),
(27, '2023-06-10', 0, '6484a01853502', 2, 29, 1),
(28, '2023-06-10', 1, '6484a01853502', 2, 26, 1),
(29, '2023-06-10', 0, '6484a01853502', 2, 28, 1),
(30, '2023-06-10', 0, '6484a01853502', 2, 27, 1),
(31, '2023-06-10', 0, '6484a01853502', 2, 30, 1),
(32, '2023-06-10', 0, '6484a01853502', 2, 31, 1),
(33, '2023-06-10', 1, '6484a01853502', 2, 25, 1),
(34, '2023-06-10', 1, '6484a6af78744', 2, 24, 1),
(35, '2023-06-10', 0, '6484a6af78744', 2, 21, 1),
(36, '2023-06-10', 0, '6484a6af78744', 2, 26, 1),
(37, '2023-06-10', 1, '6484b6a3e78e7', 2, 23, 1),
(38, '2023-06-10', 1, '6484b6a3e78e7', 2, 28, 1),
(39, '2023-06-10', 1, '6484b6a3e78e7', 2, 27, 1),
(40, '2023-06-10', 0, '6484b6a3e78e7', 2, 29, 1),
(41, '2023-06-10', 1, '6484baedcd9dc', 2, 12, 1),
(42, '2023-06-10', 0, '6484baedcd9dc', 2, 13, 1),
(43, '2023-06-10', 0, '6484baedcd9dc', 2, 14, 1),
(44, '2023-06-10', 1, '6484baedcd9dc', 2, 17, 1),
(45, '2023-06-10', 0, '6484baedcd9dc', 2, 18, 1),
(46, '2023-06-10', 0, '6484baedcd9dc', 2, 11, 1),
(47, '2023-06-10', 0, '6484baedcd9dc', 2, 20, 1),
(48, '2023-06-10', 0, '6484ea66b1425', 2, 30, 1),
(49, '2023-06-10', 0, '6484ea66b1425', 2, 31, 1),
(50, '2023-06-10', 1, '6484ea66b1425', 2, 13, 1),
(51, '2023-06-10', 0, '6484ea66b1425', 2, 18, 1),
(52, '2023-06-10', 0, '6484f28767959', 2, 20, 1),
(53, '2023-06-10', 1, '6484f28767959', 2, 11, 1),
(54, '2023-06-10', 0, '6484f28767959', 2, 14, 1),
(55, '2023-06-10', 1, '6484f28767959', 2, 21, 1),
(56, '2023-06-10', 1, '6484f28767959', 2, 15, 1),
(57, '2023-06-10', 1, '6484f28767959', 2, 12, 1),
(58, '2023-06-10', 1, '6484f28767959', 2, 19, 1),
(59, '2023-06-10', 0, '6484f28767959', 2, 16, 1),
(60, '2023-06-11', 0, '64856a8bc17c1', 1, 19, 1),
(61, '2023-06-11', 1, '64856a8bc17c1', 1, 11, 1),
(62, '2023-06-11', 1, '64856a8bc17c1', 1, 12, 1),
(63, '2023-06-11', 0, '64856a8bc17c1', 1, 24, 1),
(64, '2023-06-11', 0, '64856a8bc17c1', 1, 22, 1),
(65, '2023-06-11', 0, '64856a8bc17c1', 1, 13, 1),
(66, '2023-06-11', 0, '64856a8bc17c1', 1, 12, 1),
(67, '2023-06-11', 0, '64856a8bc17c1', 1, 11, 1),
(68, '2023-06-11', 0, '64856a8bc17c1', 1, 19, 1),
(69, '2023-06-11', 0, '64856a8bc17c1', 1, 13, 1),
(70, '2023-06-11', 0, '64856a8bc17c1', 1, 20, 1),
(71, '2023-06-11', 0, '64856b146238f', 1, 16, 1),
(72, '2023-06-11', 0, '648576b5a14b7', 3, 22, 1),
(73, '2023-06-11', 0, '648576b5a14b7', 3, 19, 1),
(74, '2023-06-11', 0, '648576b5a14b7', 3, 11, 1),
(75, '2023-06-11', 0, '648582190ab73', 1, 22, 1),
(76, '2023-06-11', 0, '648582190ab73', 1, 18, 1),
(77, '2023-06-11', 0, '648582190ab73', 1, 14, 1),
(78, '2023-06-11', 0, '648582190ab73', 1, 21, 1),
(79, '2023-06-11', 1, '648582190ab73', 1, 25, 1),
(80, '2023-06-11', 0, '648582190ab73', 1, 23, 1),
(81, '2023-06-11', 0, '648582190ab73', 1, 28, 1),
(82, '2023-06-11', 0, '6485981d3ab62', 3, 16, 1),
(83, '2023-06-11', 0, '6485ef1c68ea9', 3, 20, 1),
(84, '2023-06-11', 0, '6485ef25b219c', 3, 18, 1),
(85, '2023-06-11', 0, '6485ef25b219c', 3, 21, 1),
(86, '2023-06-11', 0, '6485ef43bcee7', 3, 13, 1),
(87, '2023-06-11', 1, '6485ef589a07d', 3, 24, 1),
(88, '2023-06-11', 0, '6485ef589a07d', 3, 23, 1),
(89, '2023-06-11', 0, '6485ef589a07d', 3, 25, 1),
(90, '2023-06-11', 0, '6485ef589a07d', 3, 14, 1),
(91, '2023-06-11', 0, '64861754df2af', 3, 26, 1),
(92, '2023-06-11', 0, '648617c81f7ad', 3, 27, 1),
(93, '2023-06-11', 0, '648617ccea0d7', 3, 30, 1),
(94, '2023-06-11', 1, '648617d187466', 3, 29, 1),
(95, '2023-06-11', 0, '648617d187466', 3, 31, 1),
(96, '2023-06-11', 0, '64864aca80375', 3, 28, 1),
(97, '2023-06-13', 0, '6488f3b6c4944', 1, 30, 1),
(98, '2023-06-14', 0, '648a637a5abb8', 3, 18, 1),
(99, '2023-06-19', 1, '6490c7864b732', 3, 13, 1),
(100, '2023-06-19', 0, '6490c7864b732', 3, 14, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historialusuario`
--

DROP TABLE IF EXISTS `historialusuario`;
CREATE TABLE IF NOT EXISTS `historialusuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idUs` int(11) DEFAULT NULL,
  `idPreg` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Historial_Usuario` (`idUs`),
  KEY `FK_Historial_Pregunta` (`idPreg`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historialusuario`
--

INSERT INTO `historialusuario` (`id`, `idUs`, `idPreg`) VALUES
(50, 2, 13),
(51, 2, 18),
(52, 2, 20),
(53, 2, 11),
(54, 2, 14),
(55, 2, 21),
(56, 2, 15),
(57, 2, 12),
(58, 2, 19),
(59, 2, 16),
(66, 1, 12),
(67, 1, 11),
(68, 1, 19),
(69, 1, 13),
(70, 1, 20),
(71, 1, 16),
(75, 1, 22),
(76, 1, 18),
(77, 1, 14),
(78, 1, 21),
(79, 1, 25),
(80, 1, 23),
(81, 1, 28),
(97, 1, 30),
(98, 3, 18),
(99, 3, 13),
(100, 3, 14);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `obtenerpreguntas`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `obtenerpreguntas`;
CREATE TABLE IF NOT EXISTS `obtenerpreguntas` (
`preguntaID` int(11)
,`pregunta` varchar(500)
,`respuestaCorrecta` int(11)
,`color` varchar(50)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta`
--

DROP TABLE IF EXISTS `pregunta`;
CREATE TABLE IF NOT EXISTS `pregunta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `preg` varchar(500) DEFAULT NULL,
  `idCat` int(11) DEFAULT NULL,
  `idEst` int(11) DEFAULT NULL,
  `resCor` int(11) DEFAULT NULL,
  `pregTot` int(11) DEFAULT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `f_creacion` date DEFAULT curdate(),
  PRIMARY KEY (`id`),
  KEY `FK_Pregunta_Categoria` (`idCat`),
  KEY `FK_Pregunta_Estado` (`idEst`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pregunta`
--

INSERT INTO `pregunta` (`id`, `preg`, `idCat`, `idEst`, `resCor`, `pregTot`, `idUsuario`, `f_creacion`) VALUES
(1, '¿Que se celebra el 25 de Mayo?', 3, 4, 1, 1, 2, '2023-06-10'),
(2, '¿Quien gano el ultimo mundial de futbol', 4, 4, 1, 1, 2, '2023-06-10'),
(3, 'Si en un script PHP encuentra una llamada a un método de clase de la siguiente manera: Usuario::traerUsuario(); Se trata de:', 5, 1, 1, 1, 2, '2023-06-10'),
(4, 'Cuando utilizo una Clase en forma estática siempre se ejecuta el método __construct()', 5, 4, 1, 1, 2, '2023-06-10'),
(5, 'La S del acrónimo SOLID es por el concepto Single Responsability, que indica:', 5, 4, 1, 1, 2, '2023-06-10'),
(6, 'El concepto de acoplamiento refiere a:', 5, 4, 1, 1, 2, '2023-06-10'),
(7, 'Como concepto general podemos decir que a menos acoplamiento mejor software', 5, 4, 1, 1, 2, '2023-06-10'),
(8, 'En software se entiende por patrón de diseño a:', 5, 4, 1, 1, 2, '2023-06-10'),
(9, 'El patrón MVC se utiliza mucho en aplicaciones web porque:', 5, 4, 1, 1, 2, '2023-06-10'),
(10, 'En un modelo MVC el que recibe normalmente la petición del cliente es:', 5, 4, 1, 1, 2, '2023-06-10'),
(11, 'El modelo en un esquema MVC es el encargado de almacenar y ejecutar la lógica del negocio', 5, 4, 3, 8, 2, '2023-06-10'),
(12, 'Uno de los objetivos del modelo MVC es separar en la aplicación el modelo de negocios de las interfaces de usuario', 5, 4, 4, 7, 2, '2023-06-10'),
(13, 'El enrutador en un modelo MVC es el encargado de ejecutar las operaciones de acceso a la base de datos', 5, 4, 3, 9, 2, '2023-06-10'),
(14, 'El folding en una aplicación web se refiere a:', 5, 4, 1, 8, 2, '2023-06-10'),
(15, 'Si estoy desarrollando usando TDD estoy', 5, 4, 3, 4, 2, '2023-06-10'),
(16, 'El patrón MVC esta compuesto por:', 5, 4, 1, 6, 2, '2023-06-10'),
(17, 'En un patrón MVC la Vista es la encargada de ', 5, 4, 3, 4, 2, '2023-06-10'),
(18, 'La principal diferencia entre los enfoques Responsive y Mobile First es', 5, 4, 1, 8, 2, '2023-06-10'),
(19, 'Observando la siguiente imagen, cuál de las dos opciones (A o B) le parece más adecuada para describir el enfoque Mobile first.', 5, 4, 2, 7, 2, '2023-06-10'),
(20, 'La principal diferencia entre una Aplicación Web y una Aplicación monolítica (por ejemplo una Win32) es:', 5, 4, 1, 7, 2, '2023-06-10'),
(21, 'El protocolo a través del cuál se realiza todo el intercambio de datos entre un servidor web y un cliente es:', 5, 4, 2, 12, 2, '2023-06-10'),
(22, 'El protocolo HTTP tiene entre sus caracteristicas ser:', 5, 4, 3, 11, 2, '2023-06-10'),
(23, 'El protocolo DNS es:', 5, 4, 2, 11, 2, '2023-06-10'),
(24, 'El protocolo HTTP implementa comandos, entre ellos:', 5, 4, 4, 11, 2, '2023-06-10'),
(25, 'El protyocolo HTTP implementa codigos de error de respuesta, si recibo un codigo de la serie 500, ha ocurrido:', 5, 4, 3, 11, 2, '2023-06-10'),
(26, 'El protyocolo HTTP implementa codigos de error de respuesta, si recibo un codigo de la serie 400, ha ocurrido:', 5, 4, 2, 10, 2, '2023-06-10'),
(27, 'El protyocolo HTTP implementa codigos de error de respuesta, si recibo un codigo de la serie 200, ha ocurrido:', 5, 4, 2, 10, 2, '2023-06-10'),
(28, 'En una petición GET, los parametros de la petición se pasan a través de....', 5, 4, 2, 11, 2, '2023-06-10'),
(29, 'Se denomina Scripting del lado del cliente, o programación Front-end o Client Side Scripting a :', 5, 4, 2, 10, 2, '2023-06-10'),
(30, 'Se denomina Scripting del lado del servidor, o programación Back-end o Server Side Scripting a :', 5, 4, 2, 11, 2, '2023-06-10'),
(31, 'La petición de un recurso determinado a un sitio Web (imagen, archivo, etc.) se canaliza mediante:', 5, 4, 1, 10, 2, '2023-06-10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta_respuesta_correcta`
--

DROP TABLE IF EXISTS `pregunta_respuesta_correcta`;
CREATE TABLE IF NOT EXISTS `pregunta_respuesta_correcta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idPreg` int(11) DEFAULT NULL,
  `idResp` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Pregunta_Respuesta` (`idPreg`),
  KEY `FK_Pregunta_Opcion` (`idResp`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pregunta_respuesta_correcta`
--

INSERT INTO `pregunta_respuesta_correcta` (`id`, `idPreg`, `idResp`) VALUES
(1, 1, 1),
(2, 2, 5),
(3, 3, 10),
(4, 4, 14),
(5, 5, 17),
(6, 6, 19),
(7, 7, 23),
(8, 8, 26),
(9, 9, 31),
(10, 10, 36),
(11, 11, 37),
(12, 12, 39),
(13, 13, 42),
(14, 14, 45),
(15, 15, 50),
(16, 16, 51),
(17, 17, 55),
(18, 18, 60),
(19, 19, 65),
(20, 20, 70),
(21, 21, 72),
(22, 22, 76),
(23, 23, 83),
(24, 24, 84),
(25, 25, 90),
(26, 26, 95),
(27, 27, 96),
(28, 28, 102),
(29, 29, 104),
(30, 30, 109),
(31, 31, 112);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `ranking`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `ranking`;
CREATE TABLE IF NOT EXISTS `ranking` (
`nombreUsuario` varchar(50)
,`puntaje` decimal(23,0)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportepregunta`
--

DROP TABLE IF EXISTS `reportepregunta`;
CREATE TABLE IF NOT EXISTS `reportepregunta` (
  `idReporte` int(11) NOT NULL AUTO_INCREMENT,
  `idUsuario` int(11) DEFAULT NULL,
  `idPregunta` int(11) DEFAULT NULL,
  `f_reporte` date DEFAULT curdate(),
  PRIMARY KEY (`idReporte`),
  KEY `Fk_reportePregunta_idUsuario` (`idUsuario`),
  KEY `Fk_reportePregunta_idPregunta` (`idPregunta`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reportepregunta`
--

INSERT INTO `reportepregunta` (`idReporte`, `idUsuario`, `idPregunta`, `f_reporte`) VALUES
(1, 2, 14, '2023-06-10'),
(2, 2, 11, '2023-06-10'),
(3, 1, 22, '2023-06-11'),
(4, 1, 18, '2023-06-11'),
(5, 3, 31, '2023-06-11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuesta`
--

DROP TABLE IF EXISTS `respuesta`;
CREATE TABLE IF NOT EXISTS `respuesta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `resp` varchar(500) DEFAULT NULL,
  `idPreg` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Opcion_Pregunta` (`idPreg`)
) ENGINE=InnoDB AUTO_INCREMENT=116 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `respuesta`
--

INSERT INTO `respuesta` (`id`, `resp`, `idPreg`) VALUES
(1, 'Revolución de Mayo', 1),
(2, 'Día de la Independencia', 1),
(3, 'Fallecimiento de Guemes', 1),
(4, 'Navidad', 1),
(5, 'Argentina', 2),
(6, 'Francia', 2),
(7, 'Chile', 2),
(8, 'Paises Bajos', 2),
(9, 'Una llamada al método por referencia', 3),
(10, 'Un métido de una Clase invocado en forma estática', 3),
(11, 'Llamada a un constructor', 3),
(12, 'Instanciación de una Clase', 3),
(13, 'Verdadero', 4),
(14, 'Falso', 4),
(15, 'Que una Clase solo debe ser instanciada para poder invocer un método de la misma', 5),
(16, 'Que una Clase debe cumplir la mayor cantidad de funciones dentro de mi modelo de negocios', 5),
(17, 'Que un objeto/clase debe tener una sola razón para cambiar, esto es debe tener un sólo trabajo', 5),
(18, 'Los objetos o clases deben estar abiertos por extensión, pero cerrados por modificación.', 5),
(19, 'al grado de interdependencia que tienen dos unidades de software entre sí', 6),
(20, 'al grado de independencia que tienen dos unidades de software entre sí', 6),
(21, 'al grado de comunicación que tienen dos unidades de software entre sí', 6),
(22, 'al grado de complejidad que tienen dos unidades de software', 6),
(23, 'Verdadero', 7),
(24, 'Falso', 7),
(25, 'Al dueño de un diseño determinado', 8),
(26, 'A un conjunto de técnicas aplicadas en conjunto para resolver problemas comunes al desarrollo de software', 8),
(27, 'Es la vertienrte de POO que se ocupa del desarrollo de interfaces', 8),
(28, 'En POO se denomina así a una clase que funciona como una librería en Porcedural', 8),
(29, 'Es mas lindo', 9),
(30, 'Es mas simple', 9),
(31, 'Representa bien la división de entornos en una aplicación web', 9),
(32, 'Esta desarrollado para explicar las interfaces desde una óptica de UX', 9),
(33, 'el controlador', 10),
(34, 'el modelo', 10),
(35, 'la vista', 10),
(36, 'el enrutador', 10),
(37, 'Verdadero', 11),
(38, 'Falso', 11),
(39, 'Verdadero', 12),
(40, 'Falso', 12),
(41, 'Verdadero', 13),
(42, 'Falso', 13),
(43, 'una forma de disponer de las consultas en la base de datos', 14),
(44, 'una forma de escribir el código de manera que sea legible', 14),
(45, 'una forma de ordenar el código de manera que el proyecto sea comprensible', 14),
(46, 'un método de foldear vistas', 14),
(47, 'Usando un método de programación basado en objetos', 15),
(48, 'Usando un método de programación basado en funciones', 15),
(49, 'Usando un método de programación basado en pruebas', 15),
(50, 'Usando un método de programación basado en test', 15),
(51, 'Un Modelo, una Vista y un Controlador, complementados por un enrutador', 16),
(52, 'Un Modelo, una Vista y un Controlador', 16),
(53, 'Un Modelo, una Versionador y un Controlador', 16),
(54, 'Un Microservicio, una Vista y un Controlador', 16),
(55, 'Resolver la comunicación con el usuario', 17),
(56, 'Comunicar al Controlador con el Modelo', 17),
(57, 'Resolver la lógica de negocios', 17),
(58, 'Resolver la petición del usuario', 17),
(59, 'Que el enfoque Mobile First se basa en CSS3 y HTML 5.', 18),
(60, 'Que el enfoque Mobile First se basa en la idea de diseñar pensando en el ambiente móvil y de allí llevar el diseño al desktop.', 18),
(61, 'En que el enfoque Responsive el sitio debe adaptarse a diferentes dispositivos y en el enfoque Mobile First no.', 18),
(62, 'Los dos enfoques son iguales, dos nombres para identificar o mismo.', 18),
(63, 'La 1 y 4 son correctas', 18),
(64, 'A', 19),
(65, 'B', 19),
(66, 'A y B', 19),
(67, 'Ninguna de las anteriores', 19),
(68, 'Son escencialmente iguales', 20),
(69, 'Que una aplicación web hace uso de una red TCP/IP y una aplicación monolítica no.', 20),
(70, 'Que en una aplicación web es dividida en dos partes interdependientes, una en el cliente (visualización) y otra en el servidor (lógica de negocios, acceso a datos, etc.)', 20),
(71, '1 y 2 son correctas', 20),
(72, 'HTTP/HTTPS', 21),
(73, 'DNS/HTTP', 21),
(74, 'REST', 21),
(75, '1 y 2 son correctas', 21),
(76, 'No orientado a la conexión (Conectionless) / Sin mantenimiento de estado de conexión (Stateless)', 22),
(77, 'No orientado a la conexión (Conectionless) ', 22),
(78, 'Orientado a la conexión ', 22),
(79, 'Orientado al mantenimiento de estado de conexión ', 22),
(80, 'Un protocolo de resolución de espacios de procesamiento en un entorno distribuido', 23),
(81, 'Un protocolo de cifrado de 3 niveles usado en Internet', 23),
(82, 'Un protocolo de comunicación entre sitios web y sus clientes', 23),
(83, 'Un protocolo de resolución de nombres de caracteristicas jerárquicas', 23),
(84, 'GET, POST, HEAD', 24),
(85, 'SEND, PING, SAVE', 24),
(86, 'GET, SEND, PING', 24),
(87, 'GET, POST, SEND', 24),
(88, 'Nada, informa que el procesamiento finlaizo Ok', 25),
(89, 'Informa un error en la resolcuón DNS del nombre', 25),
(90, 'Informa que ha ocurrido un error en el procesamiento de la peticion en el servidor', 25),
(91, 'Informa que ha ocurrido un error en el procesamiento de la peticion en el cliente', 25),
(92, 'Nada, informa que el procesamiento finlaizo Ok', 26),
(93, 'Informa un error en la resolcuón DNS del nombre', 26),
(94, 'Informa que ha ocurrido un error en el procesamiento de la peticion en el servidor', 26),
(95, 'Informa que ha ocurrido un error en el procesamiento de la peticion en el cliente', 26),
(96, 'Nada, informa que el procesamiento finlaizo Ok', 27),
(97, 'Informa un error en la resolcuón DNS del nombre', 27),
(98, 'Informa que ha ocurrido un error en el procesamiento de la peticion en el servidor', 27),
(99, 'Informa que ha ocurrido un error en el procesamiento de la peticion en el cliente', 27),
(100, 'El cuerpo de la petición', 28),
(101, 'Abriendo un socket', 28),
(102, 'Como parte de la URL', 28),
(103, 'No se pueden pasar parametros en una peticion GET', 28),
(104, 'Porciones de codigo ejecutable que se envian al navegador del cliente para que este los ejecute', 29),
(105, 'Porciones de codigo ejecutable que el cliente envia para quese ejecuten en el servidor', 29),
(106, 'La parte del modelo de negocios que se ejecuta en el servidor', 29),
(107, 'Ninguna de las anteriores', 29),
(108, 'Porciones de codigo ejecutable que se envian al navegador del cliente para que este los ejecute', 30),
(109, 'Porciones de código ejecutable que se ejecutan en el servidor ante una petición del cliente', 30),
(110, 'La parte del modelo de negocios que se ejecuta en el cliente', 30),
(111, 'Ninguna de las anteriores', 30),
(112, 'Una URL', 31),
(113, 'Un DNS', 31),
(114, 'Una API', 31),
(115, 'Ninguna de las anteriores', 31);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

DROP TABLE IF EXISTS `rol`;
CREATE TABLE IF NOT EXISTS `rol` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descr` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id`, `descr`) VALUES
(1, 'Administrador'),
(2, 'Editor'),
(3, 'Usuario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol_usuario`
--

DROP TABLE IF EXISTS `rol_usuario`;
CREATE TABLE IF NOT EXISTS `rol_usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idUs` int(11) DEFAULT NULL,
  `idRol` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_RolUsuario_Usuario` (`idUs`),
  KEY `FK_RolUsuario_Rol` (`idRol`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol_usuario`
--

INSERT INTO `rol_usuario` (`id`, `idUs`, `idRol`) VALUES
(1, 1, 3),
(2, 2, 2),
(3, 3, 1),
(4, 4, 3),
(6, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipopartida`
--

DROP TABLE IF EXISTS `tipopartida`;
CREATE TABLE IF NOT EXISTS `tipopartida` (
  `Id` int(11) NOT NULL,
  `descripcion` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipopartida`
--

INSERT INTO `tipopartida` (`Id`, `descripcion`) VALUES
(1, 'Solitario'),
(2, 'IA'),
(3, 'PVP');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trampa`
--

DROP TABLE IF EXISTS `trampa`;
CREATE TABLE IF NOT EXISTS `trampa` (
  `idTrampa` int(11) NOT NULL AUTO_INCREMENT,
  `descr` varchar(50) DEFAULT NULL,
  `precio` float(5,2) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  PRIMARY KEY (`idTrampa`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `trampa`
--

INSERT INTO `trampa` (`idTrampa`, `descr`, `precio`, `cantidad`) VALUES
(1, 'Pack Trampita x5', 5.00, 5),
(2, 'Pack Trampita x10', 10.00, 10),
(3, 'Pack Trampita x20', 20.00, 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `apellido` varchar(50) DEFAULT NULL,
  `nombreUsuario` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `generoId` int(11) DEFAULT NULL,
  `correo` varchar(50) DEFAULT NULL,
  `fotoPerfil` varchar(50) DEFAULT NULL,
  `f_nacimiento` date DEFAULT NULL,
  `f_registro` date DEFAULT current_timestamp(),
  `coordenadas` varchar(255) DEFAULT '',
  `activo` tinyint(1) DEFAULT NULL,
  `trampas` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `FK_Usuario_Genero` (`generoId`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `apellido`, `nombreUsuario`, `password`, `generoId`, `correo`, `fotoPerfil`, `f_nacimiento`, `f_registro`, `coordenadas`, `activo`, `trampas`) VALUES
(1, 'usuario', 'usuario', 'usuario', 'f8032d5cae3de20fcec887f395ec9a6a', 1, 'usuario@usuario.com', 'usuario.png', '1991-01-01', '2023-05-30', '-34.660461, -58.575087', 1, 1),
(2, 'editor', 'editor', 'editor', '5aee9dbd2a188839105073571bee1b1f', 1, 'editor@editor.com', 'editor.png', '1990-01-01', '2023-05-29', '-34.660461, -58.575087', 1, -6),
(3, 'admin', 'admin', 'admin2', '21232f297a57a5a743894a0e4a801fc3', 3, 'admin@admin.com', 'admin.png', '1900-01-01', '2023-05-30', '-34.660461, -58.575087', 1, 2),
(4, 'usuario1', 'usuario1', 'usuario1', '122b738600a0f74f7c331c0ef59bc34c', 2, 'usuario1@usuario1.com', 'usuario1.png', '1991-10-01', '2023-05-30', '-34.660461, -58.575087', 1, 0),
(9, 'gabriel', 'gabriel', 'gabriel', '647431b5ca55b04fdf3c2fce31ef1915', 1, 'gabirel@live.com', 'gabriel.jpg', '2002-09-09', '2023-06-11', '-34.647567,-58.535585', 1, 0);




CREATE TABLE categoriaColor(
                               id INT PRIMARY KEY AUTO_INCREMENT,
                               color VARCHAR(20),
                               descripcion VARCHAR(20),
                               activo bit
);

INSERT INTO categoriaColor(color,descripcion,activo) VALUES('red','Rojo',1);
INSERT INTO categoriaColor(color,descripcion,activo) VALUES('pink','Rosa',1);
INSERT INTO categoriaColor(color,descripcion,activo) VALUES('yellow','Amarillo',1);
INSERT INTO categoriaColor(color,descripcion,activo) VALUES('white','Blanco',1);

-- --------------------------------------------------------

--
-- Estructura para la vista `cantidadusuariosporgenero`
--
DROP TABLE IF EXISTS `cantidadusuariosporgenero`;

DROP VIEW IF EXISTS `cantidadusuariosporgenero`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `cantidadusuariosporgenero`  AS SELECT CASE WHEN `u`.`generoId` = 1 THEN 'Masculino' WHEN `u`.`generoId` = 2 THEN 'Femenino' ELSE 'No Especificado' END AS `sexo`, count(0) AS `cantidad` FROM `usuario` AS `u` GROUP BY `u`.`generoId` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `dificultaddificil`
--
DROP TABLE IF EXISTS `dificultaddificil`;

DROP VIEW IF EXISTS `dificultaddificil`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `dificultaddificil`  AS SELECT `p`.`id` AS `preguntaID`, `p`.`preg` AS `pregunta`, `prc`.`idResp` AS `respuestaCorrecta`, `c`.`color` AS `color` FROM (((`pregunta` `p` join `categoria` `c` on(`p`.`idCat` = `c`.`id`)) join `pregunta_respuesta_correcta` `prc` on(`p`.`id` = `prc`.`idPreg`)) join `estado` `e` on(`p`.`idEst` = `e`.`id`)) WHERE `p`.`resCor` / `p`.`pregTot` between 0.7 and 1 AND `e`.`descr` like 'ACTIVO' ;

-- --------------------------------------------------------

--
-- Estructura para la vista `dificultadfacil`
--
DROP TABLE IF EXISTS `dificultadfacil`;

DROP VIEW IF EXISTS `dificultadfacil`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `dificultadfacil`  AS SELECT `p`.`id` AS `preguntaID`, `p`.`preg` AS `pregunta`, `prc`.`idResp` AS `respuestaCorrecta`, `c`.`color` AS `color` FROM (((`pregunta` `p` join `categoria` `c` on(`p`.`idCat` = `c`.`id`)) join `pregunta_respuesta_correcta` `prc` on(`p`.`id` = `prc`.`idPreg`)) join `estado` `e` on(`p`.`idEst` = `e`.`id`)) WHERE `p`.`resCor` / `p`.`pregTot` between 0 and 0.3 AND `e`.`descr` like 'ACTIVO' ;

-- --------------------------------------------------------

--
-- Estructura para la vista `dificultadmedia`
--
DROP TABLE IF EXISTS `dificultadmedia`;

DROP VIEW IF EXISTS `dificultadmedia`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `dificultadmedia`  AS SELECT `p`.`id` AS `preguntaID`, `p`.`preg` AS `pregunta`, `prc`.`idResp` AS `respuestaCorrecta`, `c`.`color` AS `color` FROM (((`pregunta` `p` join `categoria` `c` on(`p`.`idCat` = `c`.`id`)) join `pregunta_respuesta_correcta` `prc` on(`p`.`id` = `prc`.`idPreg`)) join `estado` `e` on(`p`.`idEst` = `e`.`id`)) WHERE `p`.`resCor` / `p`.`pregTot` between 0.3 and 0.7 AND `e`.`descr` like 'ACTIVO' ;

-- --------------------------------------------------------

--
-- Estructura para la vista `dificultadusuario`
--
DROP TABLE IF EXISTS `dificultadusuario`;

DROP VIEW IF EXISTS `dificultadusuario`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `dificultadusuario`  AS SELECT `h`.`idUs` AS `idUs`, sum(`h`.`estado` = 0) / count(0) AS `dificultad` FROM `historialpartidas` AS `h` GROUP BY `h`.`idUs` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `obtenerpreguntas`
--
DROP TABLE IF EXISTS `obtenerpreguntas`;

DROP VIEW IF EXISTS `obtenerpreguntas`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `obtenerpreguntas`  AS SELECT `p`.`id` AS `preguntaID`, `p`.`preg` AS `pregunta`, `prc`.`idResp` AS `respuestaCorrecta`, `c`.`color` AS `color` FROM (((`pregunta` `p` join `pregunta_respuesta_correcta` `prc` on(`p`.`id` = `prc`.`idPreg`)) join `categoria` `c` on(`p`.`idCat` = `c`.`id`)) join `estado` `e` on(`p`.`idEst` = `e`.`id`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `ranking`
--
DROP TABLE IF EXISTS `ranking`;

DROP VIEW IF EXISTS `ranking`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ranking`  AS SELECT `u`.`nombreUsuario` AS `nombreUsuario`, sum(`hp`.`estado` = 1) AS `puntaje` FROM (`historialpartidas` `hp` join `usuario` `u` on(`hp`.`idUs` = `u`.`id`)) GROUP BY `hp`.`idUs` ORDER BY sum(`hp`.`estado` = 1) DESC ;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `historialcompras`
--
ALTER TABLE `historialcompras`
  ADD CONSTRAINT `FK_HistorialCompras_Trampas` FOREIGN KEY (`idTr`) REFERENCES `trampa` (`idTrampa`),
  ADD CONSTRAINT `FK_HistorialCompras_Usuario` FOREIGN KEY (`idUs`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `historialpartidas`
--
ALTER TABLE `historialpartidas`
  ADD CONSTRAINT `FK_HistorialPartida_Pregunta` FOREIGN KEY (`idPreg`) REFERENCES `pregunta` (`id`),
  ADD CONSTRAINT `FK_HistorialPartida_Usuario` FOREIGN KEY (`idUs`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `Fk_historialPartida_tipoPartida` FOREIGN KEY (`tipoPartida`) REFERENCES `tipopartida` (`Id`);

--
-- Filtros para la tabla `historialusuario`
--
ALTER TABLE `historialusuario`
  ADD CONSTRAINT `FK_Historial_Pregunta` FOREIGN KEY (`idPreg`) REFERENCES `pregunta` (`id`),
  ADD CONSTRAINT `FK_Historial_Usuario` FOREIGN KEY (`idUs`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `pregunta`
--
ALTER TABLE `pregunta`
  ADD CONSTRAINT `FK_Pregunta_Categoria` FOREIGN KEY (`idCat`) REFERENCES `categoria` (`id`),
  ADD CONSTRAINT `FK_Pregunta_Estado` FOREIGN KEY (`idEst`) REFERENCES `estado` (`id`);

--
-- Filtros para la tabla `pregunta_respuesta_correcta`
--
ALTER TABLE `pregunta_respuesta_correcta`
  ADD CONSTRAINT `FK_Pregunta_Opcion` FOREIGN KEY (`idResp`) REFERENCES `respuesta` (`id`),
  ADD CONSTRAINT `FK_Pregunta_Respuesta` FOREIGN KEY (`idPreg`) REFERENCES `pregunta` (`id`);

--
-- Filtros para la tabla `reportepregunta`
--
ALTER TABLE `reportepregunta`
  ADD CONSTRAINT `Fk_reportePregunta_idPregunta` FOREIGN KEY (`idPregunta`) REFERENCES `pregunta` (`id`),
  ADD CONSTRAINT `Fk_reportePregunta_idUsuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `respuesta`
--
ALTER TABLE `respuesta`
  ADD CONSTRAINT `FK_Opcion_Pregunta` FOREIGN KEY (`idPreg`) REFERENCES `pregunta` (`id`);

--
-- Filtros para la tabla `rol_usuario`
--
ALTER TABLE `rol_usuario`
  ADD CONSTRAINT `FK_RolUsuario_Rol` FOREIGN KEY (`idRol`) REFERENCES `rol` (`id`),
  ADD CONSTRAINT `FK_RolUsuario_Usuario` FOREIGN KEY (`idUs`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `FK_Usuario_Genero` FOREIGN KEY (`generoId`) REFERENCES `genero` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
