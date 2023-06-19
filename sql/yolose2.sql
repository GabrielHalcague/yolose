DROP DATABASE IF EXISTS yolose2;

CREATE DATABASE IF NOT EXISTS yolose2;
USE yolose2;

CREATE TABLE IF NOT EXISTS trampa
(
    idTrampa int(11) PRIMARY KEY AUTO_INCREMENT,
    descr    varchar(50),
    cantidad int,
    precio   float(5, 2)
);

CREATE TABLE IF NOT EXISTS genero
(
    id    int(11) PRIMARY KEY AUTO_INCREMENT,
    descr varchar(50)
);

CREATE TABLE IF NOT EXISTS rol
(
    id    int(11) PRIMARY KEY AUTO_INCREMENT,
    descr varchar(50)
);


CREATE TABLE IF NOT EXISTS usuario
(
    id            int(11) PRIMARY KEY AUTO_INCREMENT,
    nombre        varchar(50),
    apellido      varchar(50),
    nombreUsuario varchar(50),
    password      varchar(50),
    generoId      int(11),
    correo        varchar(50),
    fotoPerfil    varchar(50),
    f_nacimiento  date,
    f_registro    date         DEFAULT current_timestamp(),
    coordenadas   varchar(255) DEFAULT '-34.670616392464304, -58.56284811910162',
    activo        tinyint(1),
    trampas       int(11)      DEFAULT 0,
    CONSTRAINT FK_Usuario_Genero FOREIGN KEY (generoId) REFERENCES genero (id)
);

CREATE TABLE IF NOT EXISTS historialCompras
(
    id       int(11) PRIMARY KEY AUTO_INCREMENT,
    f_compra date DEFAULT curdate(),
    cant     int(11),
    idUs     int(11),
    idTr     int(11),
    CONSTRAINT FK_HistorialCompras_Usuario FOREIGN KEY (idUs) REFERENCES usuario (id),
    CONSTRAINT FK_HistorialCompras_Trampas FOREIGN KEY (idTr) REFERENCES trampa (idTrampa)
);

CREATE TABLE IF NOT EXISTS rol_usuario
(
    id    int(11) PRIMARY KEY AUTO_INCREMENT,
    idUs  int(11),
    idRol int(11),
    CONSTRAINT FK_RolUsuario_Usuario FOREIGN KEY (idUs) REFERENCES usuario (id),
    CONSTRAINT FK_RolUsuario_Rol FOREIGN KEY (idRol) REFERENCES rol (id)
);

CREATE TABLE IF NOT EXISTS categoria
(
    id    int(11) PRIMARY KEY AUTO_INCREMENT,
    categ varchar(50),
    color varchar(50)
);

CREATE TABLE IF NOT EXISTS estado
(
    id    int(11) PRIMARY KEY AUTO_INCREMENT,
    descr varchar(50)
);

CREATE TABLE IF NOT EXISTS pregunta
(
    id      int(11) PRIMARY KEY AUTO_INCREMENT,
    preg    varchar(500),
    f_creacion date DEFAULT curdate(),
    idCat   int(11),
    idEst   int(11),
    resCor  int(11),
    pregTot int(11),
    idUsuario int DEFAULT 2,
    CONSTRAINT FK_Pregunta_Categoria FOREIGN KEY (idCat) REFERENCES categoria (id),
    CONSTRAINT FK_Pregunta_Estado FOREIGN KEY (idEst) REFERENCES estado (id),
    CONSTRAINT FK_Pregunta_Usuario FOREIGN KEY (idUsuario) REFERENCES usuario (id)
);

CREATE TABLE IF NOT EXISTS respuesta
(
    id     int(11) PRIMARY KEY AUTO_INCREMENT,
    resp   varchar(500),
    idPreg int(11),
    CONSTRAINT FK_Opcion_Pregunta FOREIGN KEY (idPreg) REFERENCES pregunta (id)
);

CREATE TABLE IF NOT EXISTS pregunta_respuesta_correcta
(
    id     int(11) PRIMARY KEY AUTO_INCREMENT,
    idPreg int(11),
    idResp int(11),
    CONSTRAINT FK_Pregunta_Respuesta FOREIGN KEY (idPreg) REFERENCES pregunta (id),
    CONSTRAINT FK_Pregunta_Opcion FOREIGN KEY (idResp) REFERENCES respuesta (id)
);

DROP TABLE IF EXISTS historialUsuario;
CREATE TABLE IF NOT EXISTS historialUsuario
(
    id     int(11) PRIMARY KEY AUTO_INCREMENT,
    idUs   int(11),
    idPreg int(11),
    CONSTRAINT FK_Historial_Usuario FOREIGN KEY (idUs) REFERENCES usuario (id),
    CONSTRAINT FK_Historial_Pregunta FOREIGN KEY (idPreg) REFERENCES pregunta (id)
);

CREATE TABLE tipoPartida(
	Id INT PRIMARY KEY auto_increment,
    descripcion VARCHAR(20)
);

DROP TABLE IF EXISTS historialPartidas;
CREATE TABLE IF NOT EXISTS historialPartidas
(
    id        int(11) PRIMARY KEY AUTO_INCREMENT,
    n_partida varchar(50),
    f_partida date    DEFAULT curdate(),
    estado    BOOLEAN DEFAULT false,
    estadoPartida int(11) DEFAULT 0,
    idUs      int(11),
    idPreg    int(11),
    tipoPartida int(11),
    CONSTRAINT FK_HistorialPartida_Usuario FOREIGN KEY (idUs) REFERENCES usuario (id),
    CONSTRAINT FK_HistorialPartida_Pregunta FOREIGN KEY (idPreg) REFERENCES pregunta (id),
    CONSTRAINT Fk_HistorialPartida_tipoPartida FOREIGN KEY (tipoPartida) REFERENCES tipoPartida(Id)
);

CREATE TABLE IF NOT EXISTS reportePregunta(
    idReporte int primary key auto_increment,
    idUsuario int,
    idPregunta int,
    f_reporte date default curdate(),
    constraint foreign key idUsuario (idUsuario) references usuario(id),
    foreign key idPregunta (idPregunta) references pregunta(id)
);

INSERT INTO tipoPartida(descripcion) VALUES ('Solitario'),('IA'),('PVP');

INSERT INTO trampa(descr,cantidad,precio) 
VALUES ('Pack Trampita x5',5,5),
	   ('Pack Trampita x10',10,10),
	   ('Pack Trampita x20',20,20);

INSERT into genero (descr)
VALUES ('Masculino'),
       ('Femenino'),
       ('Prefiero no Cargarlo');

INSERT INTO rol (descr)
VALUES ('Administrador'),
       ('Editor'),
       ('Usuario');

INSERT INTO `usuario` (`nombre`, `apellido`, `correo`, `password`, `activo`, `nombreUsuario`, `f_nacimiento`,
                       `generoId`, `f_registro`, `fotoPerfil`)
VALUES ('usuario', 'usuario', 'usuario@usuario.com', 'f8032d5cae3de20fcec887f395ec9a6a', 1, 'usuario', '1991-01-01', 1,
        '2023-05-30 09:55:32', 'usuario.png'),
       ('editor', 'editor', 'editor@editor.com', '5aee9dbd2a188839105073571bee1b1f', 1, 'editor', '1990-01-01', 1,
        '2023-05-29 09:55:32', 'editor.png'),
       ('admin', 'admin', 'admin@admin.com', '21232f297a57a5a743894a0e4a801fc3', 1, 'admin', '1991-01-01', 1,
        '2023-05-30 09:45:32', 'admin.png'),
       ('usuario1', 'usuario1', 'usuario1@usuario1.com', '122b738600a0f74f7c331c0ef59bc34c', 1, 'usuario1',
        '1991-10-01', 2, '2023-05-30 09:55:31', 'usuario1.png'),
       ('gab', 'gab', 'gabirel@live.com', '639bee393eecbc62256936a8e64d17b1', 1, 'gab', '1991-01-01', 1,
        '2023-05-30 09:55:32', 'gab.png');

INSERT INTO rol_usuario (idUs, idRol)
VALUES (1, 3),
       (2, 2),
       (3, 1),
       (4, 3),
       (5, 3);

INSERT INTO `categoria` (`categ`, `color`)
VALUES ('Geografía', 'brown'),
       ('Ciencia', 'purple'),
       ('Historia', 'blue'),
       ('Deporte', 'green'),
       ('Tecnologia', 'blueviolet'),
       ('Entretenimiento', 'orange'),
       ('Peliculas', 'turquoise');

INSERT INTO estado (descr)
VALUES ('PENDIENTE APROBACIÓN'),
       ('REPORTADO'),
       ('ELIMINADO'),
       ('ACTIVO');

INSERT INTO pregunta (preg, idCat, idEst, resCor, pregTot)
VALUES ('¿Que se celebra el 25 de Mayo?', 3, 4, 1, 1),
('¿Quien gano el ultimo mundial de futbol', 4, 4, 1, 1),
( 'Si en un script PHP encuentra una llamada a un método de clase de la siguiente manera: Usuario::traerUsuario(); Se trata de:', 5, 4, 1, 1),
( 'Cuando utilizo una Clase en forma estática siempre se ejecuta el método __construct()', 5, 4, 1, 1),
( 'La S del acrónimo SOLID es por el concepto Single Responsability, que indica:', 5, 4, 1, 1),
( 'El concepto de acoplamiento refiere a:', 5, 4, 1, 1),
( 'Como concepto general podemos decir que a menos acoplamiento mejor software', 5, 4, 1, 1),
( 'En software se entiende por patrón de diseño a:', 5, 4, 1, 1),
( 'El patrón MVC se utiliza mucho en aplicaciones web porque:', 5, 4, 1, 1),
( 'En un modelo MVC el que recibe normalmente la petición del cliente es:', 5, 4, 1, 1),
( 'El modelo en un esquema MVC es el encargado de almacenar y ejecutar la lógica del negocio', 5, 4, 1, 2),
( 'Uno de los objetivos del modelo MVC es separar en la aplicación el modelo de negocios de las interfaces de usuario', 5, 4, 1, 2),
( 'El enrutador en un modelo MVC es el encargado de ejecutar las operaciones de acceso a la base de datos', 5, 4, 1, 2),
( 'El folding en una aplicación web se refiere a:', 5, 4, 1, 2),
( 'Si estoy desarrollando usando TDD estoy', 5, 4, 1, 2),
( 'El patrón MVC esta compuesto por:', 5, 4, 1, 2),
( 'En un patrón MVC la Vista es la encargada de ', 5, 4, 1, 2),
( 'La principal diferencia entre los enfoques Responsive y Mobile First es', 5, 4, 1, 2),
( 'Observando la siguiente imagen, cuál de las dos opciones (A o B) le parece más adecuada para describir el enfoque Mobile first.', 5, 4, 1, 2),
( 'La principal diferencia entre una Aplicación Web y una Aplicación monolítica (por ejemplo una Win32) es:', 5, 4, 1, 2),
( 'El protocolo a través del cuál se realiza todo el intercambio de datos entre un servidor web y un cliente es:', 5, 4, 1, 8),
( 'El protocolo HTTP tiene entre sus caracteristicas ser:', 5, 4, 1, 8),
( 'El protocolo DNS es:', 5, 4, 1, 8),
( 'El protocolo HTTP implementa comandos, entre ellos:', 5, 4, 1, 8),
( 'El protyocolo HTTP implementa codigos de error de respuesta, si recibo un codigo de la serie 500, ha ocurrido:', 5, 4, 1, 8),
( 'El protyocolo HTTP implementa codigos de error de respuesta, si recibo un codigo de la serie 400, ha ocurrido:', 5, 4, 1, 8),
( 'El protyocolo HTTP implementa codigos de error de respuesta, si recibo un codigo de la serie 200, ha ocurrido:', 5, 4, 1, 8),
( 'En una petición GET, los parametros de la petición se pasan a través de....', 5, 4, 1, 8),
( 'Se denomina Scripting del lado del cliente, o programación Front-end o Client Side Scripting a :', 5, 4, 1, 8),
( 'Se denomina Scripting del lado del servidor, o programación Back-end o Server Side Scripting a :', 5, 4, 1, 8),
( 'La petición de un recurso determinado a un sitio Web (imagen, archivo, etc.) se canaliza mediante:', 5, 4, 1, 8);

INSERT INTO respuesta (resp, idPreg)
VALUES 
('Revolución de Mayo', 1),
('Día de la Independencia', 1),
('Fallecimiento de Guemes', 1),
('Navidad', 1),
('Argentina', 2),
('Francia', 2),
('Chile', 2),
('Paises Bajos', 2),
( 'Una llamada al método por referencia',3 ),
( 'Un métido de una Clase invocado en forma estática',3 ),
( 'Llamada a un constructor',3 ),
( 'Instanciación de una Clase',3 ),
( 'Verdadero',4 ),
( 'Falso',4 ),
( 'Que una Clase solo debe ser instanciada para poder invocer un método de la misma',5 ),
( 'Que una Clase debe cumplir la mayor cantidad de funciones dentro de mi modelo de negocios',5 ),
( 'Que un objeto/clase debe tener una sola razón para cambiar, esto es debe tener un sólo trabajo',5 ),
( 'Los objetos o clases deben estar abiertos por extensión, pero cerrados por modificación.',5 ),
( 'al grado de interdependencia que tienen dos unidades de software entre sí',6 ),
( 'al grado de independencia que tienen dos unidades de software entre sí',6 ),
( 'al grado de comunicación que tienen dos unidades de software entre sí',6 ),
( 'al grado de complejidad que tienen dos unidades de software',6 ),
( 'Verdadero',7 ),
( 'Falso',7 ),
( 'Al dueño de un diseño determinado',8 ),
( 'A un conjunto de técnicas aplicadas en conjunto para resolver problemas comunes al desarrollo de software',8 ),
( 'Es la vertienrte de POO que se ocupa del desarrollo de interfaces',8 ),
( 'En POO se denomina así a una clase que funciona como una librería en Porcedural',8 ),
( 'Es mas lindo',9 ),
( 'Es mas simple',9 ),
( 'Representa bien la división de entornos en una aplicación web',9 ),
( 'Esta desarrollado para explicar las interfaces desde una óptica de UX',9 ),
( 'el controlador',10 ),
( 'el modelo',10 ),
( 'la vista',10 ),
( 'el enrutador',10 ),
( 'Verdadero',11 ),
( 'Falso',11 ),
( 'Verdadero',12 ),
( 'Falso',12 ),
( 'Verdadero',13 ),
( 'Falso',13 ),
( 'una forma de disponer de las consultas en la base de datos',14 ),
( 'una forma de escribir el código de manera que sea legible',14 ),
( 'una forma de ordenar el código de manera que el proyecto sea comprensible',14 ),
( 'un método de foldear vistas',14 ),
( 'Usando un método de programación basado en objetos',15 ),
( 'Usando un método de programación basado en funciones',15 ),
( 'Usando un método de programación basado en pruebas',15 ),
( 'Usando un método de programación basado en test',15 ),
( 'Un Modelo, una Vista y un Controlador, complementados por un enrutador',16 ),
( 'Un Modelo, una Vista y un Controlador',16 ),
( 'Un Modelo, una Versionador y un Controlador',16 ),
( 'Un Microservicio, una Vista y un Controlador',16 ),
( 'Resolver la comunicación con el usuario',17 ),
( 'Comunicar al Controlador con el Modelo',17 ),
( 'Resolver la lógica de negocios',17 ),
( 'Resolver la petición del usuario',17 ),
( 'Que el enfoque Mobile First se basa en CSS3 y HTML 5.',18 ),
( 'Que el enfoque Mobile First se basa en la idea de diseñar pensando en el ambiente móvil y de allí llevar el diseño al desktop.',18 ),
( 'En que el enfoque Responsive el sitio debe adaptarse a diferentes dispositivos y en el enfoque Mobile First no.',18 ),
( 'Los dos enfoques son iguales, dos nombres para identificar o mismo.',18 ),
( 'La 1 y 4 son correctas',18 ),
( 'A',19 ),
( 'B',19 ),
( 'A y B',19 ),
( 'Ninguna de las anteriores',19 ),
( 'Son escencialmente iguales',20 ),
( 'Que una aplicación web hace uso de una red TCP/IP y una aplicación monolítica no.',20 ),
( 'Que en una aplicación web es dividida en dos partes interdependientes, una en el cliente (visualización) y otra en el servidor (lógica de negocios, acceso a datos, etc.)',20 ),
( '1 y 2 son correctas',20 ),
( 'HTTP/HTTPS',21 ),
( 'DNS/HTTP',21 ),
( 'REST',21 ),
( '1 y 2 son correctas',21 ),
( 'No orientado a la conexión (Conectionless) / Sin mantenimiento de estado de conexión (Stateless)',22 ),
( 'No orientado a la conexión (Conectionless) ',22 ),
( 'Orientado a la conexión ',22 ),
( 'Orientado al mantenimiento de estado de conexión ',22 ),
( 'Un protocolo de resolución de espacios de procesamiento en un entorno distribuido',23 ),
( 'Un protocolo de cifrado de 3 niveles usado en Internet',23 ),
( 'Un protocolo de comunicación entre sitios web y sus clientes',23 ),
( 'Un protocolo de resolución de nombres de caracteristicas jerárquicas',23 ),
( 'GET, POST, HEAD',24 ),
( 'SEND, PING, SAVE',24 ),
( 'GET, SEND, PING',24 ),
( 'GET, POST, SEND',24 ),
( 'Nada, informa que el procesamiento finlaizo Ok',25 ),
( 'Informa un error en la resolcuón DNS del nombre',25 ),
( 'Informa que ha ocurrido un error en el procesamiento de la peticion en el servidor',25 ),
( 'Informa que ha ocurrido un error en el procesamiento de la peticion en el cliente',25 ),
( 'Nada, informa que el procesamiento finlaizo Ok',26 ),
( 'Informa un error en la resolcuón DNS del nombre',26 ),
( 'Informa que ha ocurrido un error en el procesamiento de la peticion en el servidor',26 ),
( 'Informa que ha ocurrido un error en el procesamiento de la peticion en el cliente',26 ),
( 'Nada, informa que el procesamiento finlaizo Ok',27 ),
( 'Informa un error en la resolcuón DNS del nombre',27 ),
( 'Informa que ha ocurrido un error en el procesamiento de la peticion en el servidor',27 ),
( 'Informa que ha ocurrido un error en el procesamiento de la peticion en el cliente',27 ),
( 'El cuerpo de la petición',28 ),
( 'Abriendo un socket',28 ),
( 'Como parte de la URL',28 ),
( 'No se pueden pasar parametros en una peticion GET',28 ),
( 'Porciones de codigo ejecutable que se envian al navegador del cliente para que este los ejecute',29 ),
( 'Porciones de codigo ejecutable que el cliente envia para quese ejecuten en el servidor',29 ),
( 'La parte del modelo de negocios que se ejecuta en el servidor',29 ),
( 'Ninguna de las anteriores',29 ),
( 'Porciones de codigo ejecutable que se envian al navegador del cliente para que este los ejecute',30 ),
( 'Porciones de código ejecutable que se ejecutan en el servidor ante una petición del cliente',30 ),
( 'La parte del modelo de negocios que se ejecuta en el cliente',30 ),
( 'Ninguna de las anteriores',30 ),
( 'Una URL',31 ),
( 'Un DNS',31 ),
( 'Una API',31 ),
( 'Ninguna de las anteriores',31 );


INSERT INTO pregunta_respuesta_correcta (idPreg, idResp)
VALUES (1, 1),(2, 5),
(3,10 ),
(4,14 ),
(5,17 ),
(6,19 ),
(7,23 ),
(8,26 ),
(9,31 ),
(10,36 ),
(11,37 ),
(12,39 ),
(13,42 ),
(14,45 ),
(15,50 ),
(16,51 ),
(17,55 ),
(18,60 ),
(19,65 ),
(20,70 ),
(21,72 ),
(22,76 ),
(23,83 ),
(24,84 ),
(25,90 ),
(26,95 ),
(27,96 ),
(28,102 ),
(29,104 ),
(30,109 ),
(31,112);

/* DEFINICION DE VISTAS */

CREATE VIEW IF NOT EXISTS dificultadMedia AS
SELECT p.id 'preguntaID', p.preg 'pregunta', prc.idResp 'respuestaCorrecta', c.color
FROM pregunta p
         JOIN categoria c ON p.idCat = c.id
         JOIN pregunta_respuesta_correcta prc ON p.id = prc.idPreg
         JOIN estado e ON p.idEst = e.id
WHERE (p.resCor / p.pregTot) BETWEEN 0.3 AND 0.7
  AND e.descr LIKE 'ACTIVO';

CREATE VIEW IF NOT EXISTS dificultadFacil AS
SELECT p.id 'preguntaID', p.preg 'pregunta', prc.idResp 'respuestaCorrecta', c.color
FROM pregunta p
         JOIN categoria c ON p.idCat = c.id
         JOIN pregunta_respuesta_correcta prc ON p.id = prc.idPreg
         JOIN estado e ON p.idEst = e.id
WHERE (p.resCor / p.pregTot) BETWEEN 0 AND 0.3
  AND e.descr LIKE 'ACTIVO';

CREATE VIEW IF NOT EXISTS dificultadDificil AS
SELECT p.id 'preguntaID', p.preg 'pregunta', prc.idResp 'respuestaCorrecta', c.color
FROM pregunta p
         JOIN categoria c ON p.idCat = c.id
         JOIN pregunta_respuesta_correcta prc ON p.id = prc.idPreg
         JOIN estado e ON p.idEst = e.id
WHERE (p.resCor / p.pregTot) BETWEEN 0.7 AND 1
  AND e.descr LIKE 'ACTIVO';

CREATE VIEW IF NOT EXISTS dificultadUsuario AS
SELECT h.idUs, SUM(h.estado = 0) / COUNT(*) 'dificultad'
FROM historialPartidas h
GROUP BY h.idUs;

CREATE VIEW IF NOT EXISTS obtenerPreguntas AS
SELECT p.id 'preguntaID', p.preg 'pregunta', prc.idResp 'respuestaCorrecta', c.color
FROM pregunta p
         JOIN pregunta_respuesta_correcta prc ON p.id = prc.idPreg
         JOIN categoria c ON p.idCat = c.id
         JOIN estado e ON p.idEst = e.id;