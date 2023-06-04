-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-06-2023 a las 01:10:17
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
(12, 'azul', 0, 1),
(15, 'Una llamada al método por referencia', 0, 3),
(16, 'Un métido de una Clase invocado en forma estática', 1, 3),
(17, 'Llamada a un constructor', 0, 3),
(18, 'Instanciación de una Clase', 0, 3),
(19, 'Verdadero', 0, 4),
(20, 'Falso', 1, 4),
(21, 'Que una Clase solo debe ser instanciada para poder invocer un método de la misma', 0, 5),
(22, 'Que una Clase debe cumplir la mayor cantidad de funciones dentro de mi modelo de negocios', 0, 5),
(23, 'Que un objeto/clase debe tener una sola razón para cambiar, esto es debe tener un sólo trabajo', 1, 5),
(24, 'Los objetos o clases deben estar abiertos por extensión, pero cerrados por modificación.', 0, 5),
(25, 'al grado de interdependencia que tienen dos unidades de software entre sí', 1, 6),
(26, 'al grado de independencia que tienen dos unidades de software entre sí', 0, 6),
(27, 'al grado de comunicación que tienen dos unidades de software entre sí', 0, 6),
(28, 'al grado de complejidad que tienen dos unidades de software', 0, 6),
(29, 'Verdadero', 1, 7),
(30, 'Falso', 0, 7),
(31, 'Al dueño de un diseño determinado', 0, 8),
(32, 'A un conjunto de técnicas aplicadas en conjunto para resolver problemas comunes al desarrollo de software', 1, 8),
(33, 'Es la vertienrte de POO que se ocupa del desarrollo de interfaces', 0, 8),
(34, 'En POO se denomina así a una clase que funciona como una librería en Porcedural', 0, 8),
(35, 'Es mas lindo', 0, 9),
(36, 'Es mas simple', 0, 9),
(37, 'Representa bien la división de entornos en una aplicación web', 1, 9),
(38, 'Esta desarrollado para explicar las interfaces desde una óptica de UX', 0, 9),
(39, 'el controlador', 0, 10),
(40, 'el modelo', 0, 10),
(41, 'la vista', 0, 10),
(42, 'el enrutador', 1, 10),
(43, 'Verdadero', 1, 11),
(44, 'Falso', 0, 11),
(45, 'Verdadero', 1, 12),
(46, 'Falso', 0, 12),
(47, 'Verdadero', 0, 13),
(48, 'Falso', 1, 13),
(49, 'una forma de disponer de las consultas en la base de datos', 0, 14),
(50, 'una forma de escribir el código de manera que sea legible', 0, 14),
(51, 'una forma de ordenar el código de manera que el proyecto sea comprensible', 1, 14),
(52, 'un método de foldear vistas', 0, 14),
(53, 'Usando un método de programación basado en objetos', 0, 15),
(54, 'Usando un método de programación basado en funciones', 0, 15),
(55, 'Usando un método de programación basado en pruebas', 0, 15),
(56, 'Usando un método de programación basado en test', 1, 15),
(57, 'Un Modelo, una Vista y un Controlador, complementados por un enrutador', 1, 16),
(58, 'Un Modelo, una Vista y un Controlador', 0, 16),
(59, 'Un Modelo, una Versionador y un Controlador', 0, 16),
(60, 'Un Microservicio, una Vista y un Controlador', 0, 16),
(61, 'Resolver la comunicación con el usuario', 1, 17),
(62, 'Comunicar al Controlador con el Modelo', 0, 17),
(63, 'Resolver la lógica de negocios', 0, 17),
(64, 'Resolver la petición del usuario', 0, 17),
(65, 'Que el enfoque Mobile First se basa en CSS3 y HTML 5.', 0, 18),
(66, 'Que el enfoque Mobile First se basa en la idea de diseñar pensando en el ambiente móvil y de allí llevar el diseño al desktop.', 1, 18),
(67, 'En que el enfoque Responsive el sitio debe adaptarse a diferentes dispositivos y en el enfoque Mobile First no.', 0, 18),
(68, 'Los dos enfoques son iguales, dos nombres para identificar o mismo.', 0, 18),
(69, 'La 1 y 4 son correctas', 0, 18),
(70, 'A', 0, 19),
(71, 'B', 1, 19),
(72, 'A y B', 0, 19),
(73, 'Ninguna de las anteriores', 0, 19),
(74, 'Son escencialmente iguales', 0, 20),
(75, 'Que una aplicación web hace uso de una red TCP/IP y una aplicación monolítica no.', 0, 20),
(76, 'Que en una aplicación web es dividida en dos partes interdependientes, una en el cliente (visualización) y otra en el servidor (lógica de negocios, acceso a datos, etc.)', 1, 20),
(77, '1 y 2 son correctas', 0, 20),
(78, 'HTTP/HTTPS', 1, 21),
(79, 'DNS/HTTP', 0, 21),
(80, 'REST', 0, 21),
(81, '1 y 2 son correctas', 0, 21),
(82, 'No orientado a la conexión (Conectionless) / Sin mantenimiento de estado de conexión (Stateless)', 1, 22),
(83, 'No orientado a la conexión (Conectionless) ', 0, 22),
(84, 'Orientado a la conexión ', 0, 22),
(85, 'Orientado al mantenimiento de estado de conexión ', 0, 22),
(86, 'Un protocolo de resolución de espacios de procesamiento en un entorno distribuido', 0, 23),
(87, 'Un protocolo de cifrado de 3 niveles usado en Internet', 0, 23),
(88, 'Un protocolo de comunicación entre sitios web y sus clientes', 0, 23),
(89, 'Un protocolo de resolución de nombres de caracteristicas jerárquicas', 1, 23),
(90, 'GET, POST, HEAD', 1, 24),
(91, 'SEND, PING, SAVE', 0, 24),
(92, 'GET, SEND, PING', 0, 24),
(93, 'GET, POST, SEND', 0, 24),
(94, 'Nada, informa que el procesamiento finlaizo Ok', 0, 25),
(95, 'Informa un error en la resolcuón DNS del nombre', 0, 25),
(96, 'Informa que ha ocurrido un error en el procesamiento de la peticion en el servidor', 1, 25),
(97, 'Informa que ha ocurrido un error en el procesamiento de la peticion en el cliente', 0, 25),
(98, 'Nada, informa que el procesamiento finlaizo Ok', 0, 26),
(99, 'Informa un error en la resolcuón DNS del nombre', 0, 26),
(100, 'Informa que ha ocurrido un error en el procesamiento de la peticion en el servidor', 0, 26),
(101, 'Informa que ha ocurrido un error en el procesamiento de la peticion en el cliente', 1, 26),
(102, 'Nada, informa que el procesamiento finlaizo Ok', 1, 27),
(103, 'Informa un error en la resolcuón DNS del nombre', 0, 27),
(104, 'Informa que ha ocurrido un error en el procesamiento de la peticion en el servidor', 0, 27),
(105, 'Informa que ha ocurrido un error en el procesamiento de la peticion en el cliente', 0, 27),
(106, 'El cuerpo de la petición', 0, 28),
(107, 'Abriendo un socket', 0, 28),
(108, 'Como parte de la URL', 1, 28),
(109, 'No se pueden pasar parametros en una peticion GET', 0, 28),
(110, 'Porciones de codigo ejecutable que se envian al navegador del cliente para que este los ejecute', 1, 29),
(111, 'Porciones de codigo ejecutable que el cliente envia para quese ejecuten en el servidor', 0, 29),
(112, 'La parte del modelo de negocios que se ejecuta en el servidor', 0, 29),
(113, 'Ninguna de las anteriores', 0, 29),
(114, 'Porciones de codigo ejecutable que se envian al navegador del cliente para que este los ejecute', 0, 30),
(115, 'Porciones de código ejecutable que se ejecutan en el servidor ante una petición del cliente', 1, 30),
(116, 'La parte del modelo de negocios que se ejecuta en el cliente', 0, 30),
(117, 'Ninguna de las anteriores', 0, 30),
(118, 'Una URL', 1, 31),
(119, 'Un DNS', 0, 31),
(120, 'Una API', 0, 31),
(121, 'Ninguna de las anteriores', 0, 31);

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
  `dificultad` int(2) NOT NULL DEFAULT 50,
  `activa` tinyint(1) NOT NULL DEFAULT 0,
  `verificada` tinyint(1) NOT NULL DEFAULT 0,
  `respuesta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pregunta`
--

INSERT INTO `pregunta` (`id`, `descripcion`, `categoria`, `cantidadDeReportes`, `dificultad`, `activa`, `verificada`, `respuesta`) VALUES
(1, 'el cielo de que color es?', 1, 0, 50, 1, 1, 1),
(3, 'Si en un script PHP encuentra una llamada a un método de clase de la siguiente manera: Usuario::traerUsuario(); Se trata de:', 2, 0, 50, 1, 1, 16),
(4, 'Cuando utilizo una Clase en forma estática siempre se ejecuta el método __construct()', 2, 0, 50, 1, 1, 20),
(5, 'La S del acrónimo SOLID es por el concepto Single Responsability, que indica:', 2, 0, 50, 1, 1, 23),
(6, 'El concepto de acoplamiento refiere a:', 2, 0, 50, 1, 1, 25),
(7, 'Como concepto general podemos decir que a menos acoplamiento mejor software', 2, 0, 50, 1, 1, 29),
(8, 'En software se entiende por patrón de diseño a:', 2, 0, 50, 1, 1, 32),
(9, 'El patrón MVC se utiliza mucho en aplicaciones web porque:', 2, 0, 50, 1, 1, 37),
(10, 'En un modelo MVC el que recibe normalmente la petición del cliente es:', 2, 0, 50, 1, 1, 42),
(11, 'El modelo en un esquema MVC es el encargado de almacenar y ejecutar la lógica del negocio', 2, 0, 50, 1, 1, 43),
(12, 'Uno de los objetivos del modelo MVC es separar en la aplicación el modelo de negocios de las interfaces de usuario', 2, 0, 50, 1, 1, 45),
(13, 'El enrutador en un modelo MVC es el encargado de ejecutar las operaciones de acceso a la base de datos', 2, 0, 50, 1, 1, 48),
(14, 'El folding en una aplicación web se refiere a:', 2, 0, 50, 1, 1, 51),
(15, 'Si estoy desarrollando usando TDD estoy', 2, 0, 50, 1, 1, 56),
(16, 'El patrón MVC esta compuesto por:', 2, 0, 50, 1, 1, 57),
(17, 'En un patrón MVC la Vista es la encargada de ', 2, 0, 50, 1, 1, 61),
(18, 'La principal diferencia entre los enfoques Responsive y Mobile First es', 2, 0, 50, 1, 1, 66),
(19, 'Observando la siguiente imagen, cuál de las dos opciones (A o B) le parece más adecuada para describir el enfoque Mobile first.', 2, 0, 50, 1, 1, 71),
(20, 'La principal diferencia entre una Aplicación Web y una Aplicación monolítica (por ejemplo una Win32) es:', 2, 0, 50, 1, 1, 76),
(21, 'El protocolo a través del cuál se realiza todo el intercambio de datos entre un servidor web y un cliente es:', 2, 0, 50, 1, 1, 78),
(22, 'El protocolo HTTP tiene entre sus caracteristicas ser:', 2, 0, 50, 1, 1, 82),
(23, 'El protocolo DNS es:', 2, 0, 50, 1, 1, 89),
(24, 'El protocolo HTTP implementa comandos, entre ellos:', 2, 0, 50, 1, 1, 90),
(25, 'El protyocolo HTTP implementa codigos de error de respuesta, si recibo un codigo de la serie 500, ha ocurrido:', 2, 0, 50, 1, 1, 96),
(26, 'El protyocolo HTTP implementa codigos de error de respuesta, si recibo un codigo de la serie 400, ha ocurrido:', 2, 0, 50, 1, 1, 101),
(27, 'El protyocolo HTTP implementa codigos de error de respuesta, si recibo un codigo de la serie 200, ha ocurrido:', 2, 0, 50, 1, 1, 102),
(28, 'En una petición GET, los parametros de la petición se pasan a través de....', 2, 0, 50, 1, 1, 108),
(29, 'Se denomina Scripting del lado del cliente, o programación Front-end o Client Side Scripting a :', 2, 0, 50, 1, 1, 110),
(30, 'Se denomina Scripting del lado del servidor, o programación Back-end o Server Side Scripting a :', 2, 0, 50, 1, 1, 115),
(31, 'La petición de un recurso determinado a un sitio Web (imagen, archivo, etc.) se canaliza mediante:', 2, 0, 50, 1, 1, 118);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

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
