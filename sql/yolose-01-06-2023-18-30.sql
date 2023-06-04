DROP DATABASE IF EXISTS yolose2;
CREATE DATABASE IF NOT EXISTS yolose2;
USE yolose2;

CREATE TABLE IF NOT EXISTS trampa
(
    idTrampa int(11) PRIMARY KEY AUTO_INCREMENT,
    descr    varchar(50),
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
    coordenadas   varchar(255) DEFAULT '',
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
    idCat   int(11),
    idEst   int(11),
    resCor  int(11),
    pregTot int(11),
    CONSTRAINT FK_Pregunta_Categoria FOREIGN KEY (idCat) REFERENCES categoria (id),
    CONSTRAINT FK_Pregunta_Estado FOREIGN KEY (idEst) REFERENCES estado (id)
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

CREATE TABLE IF NOT EXISTS historialUsuario
(
    id     int(11) PRIMARY KEY AUTO_INCREMENT,
    idUs   int(11),
    idPreg int(11),
    CONSTRAINT FK_Historial_Usuario FOREIGN KEY (idUs) REFERENCES usuario (id),
    CONSTRAINT FK_Historial_Pregunta FOREIGN KEY (idPreg) REFERENCES pregunta (id)
);

CREATE TABLE IF NOT EXISTS historialPartidas
(
    id        int(11) PRIMARY KEY AUTO_INCREMENT,
    f_partida date    DEFAULT curdate(),
    estado    BOOLEAN DEFAULT false,
    idUs      int(11),
    idPreg    int(11),
    CONSTRAINT FK_HistorialPartida_Usuario FOREIGN KEY (idUs) REFERENCES usuario (id),
    CONSTRAINT FK_HistorialPartida_Pregunta FOREIGN KEY (idPreg) REFERENCES pregunta (id)
);


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
       ('Ciencia', 'Purple'),
       ('Historia', 'Light Blue'),
       ('Deporte', 'Khaki'),
       ('Arte', 'Blue Gray'),
       ('Entretenimiento', 'Pale Green'),
       ('Peliculas', 'Pale Yellow');

INSERT INTO estado (descr)
VALUES ('PENDIENTE APROBACIÓN'),
       ('REPORTADO'),
       ('ELIMINADO'),
       ('ACTIVO');

INSERT INTO pregunta (preg, idCat, idEst, resCor, pregTot)
VALUES ('¿Que se celebra el 25 de Mayo?', 3, 4, 1, 2),
       ('¿Quien gano el ultimo mundial de futbol', 4, 4, 1, 2);

INSERT INTO respuesta (resp, idPreg)
VALUES ('Revolución de Mayo', 1),
       ('Día de la Independencia', 1),
       ('Fallecimiento de Guemes', 1),
       ('Navidad', 1),
       ('Argentina', 2),
       ('Francia', 2),
       ('Chile', 2),
       ('Paises Bajos', 2);

INSERT INTO pregunta_respuesta_correcta (idPreg, idResp)
VALUES (1, 1),
       (2, 5);

INSERT INTO historialPartidas (f_partida, idUs, idPreg, estado)
VALUES ('2023-05-20', 1, 1, true),
       ('2023-05-20', 1, 2, false),
       ('2023-05-21', 2, 1, false),
       ('2023-05-21', 3, 1, true),
       ('2023-05-21', 3, 2, false);

INSERT INTO historialUsuario (idUs, idPreg)
VALUES (1, 1),
       (1, 2),
       (2, 1),
       (3, 1),
       (3, 2);

CREATE VIEW dificultadMedia AS
SELECT p.id 'preguntaID', p.preg 'pregunta', prc.idResp 'respuestaCorrecta', c.color
FROM pregunta p
         JOIN categoria c ON p.idCat = c.id
         JOIN pregunta_respuesta_correcta prc ON p.id = prc.idPreg
         JOIN estado e ON p.idEst = e.id
WHERE (p.resCor / p.pregTot) BETWEEN 0.3 AND 0.7
  AND e.descr LIKE 'ACTIVO';

CREATE VIEW dificultadFacil AS
SELECT p.id 'preguntaID', p.preg 'pregunta', prc.idResp 'respuestaCorrecta', c.color
FROM pregunta p
         JOIN categoria c ON p.idCat = c.id
         JOIN pregunta_respuesta_correcta prc ON p.id = prc.idPreg
         JOIN estado e ON p.idEst = e.id
WHERE (p.resCor / p.pregTot) BETWEEN 0 AND 0.3
  AND e.descr LIKE 'ACTIVO';

CREATE VIEW dificultadDificil AS
SELECT p.id 'preguntaID', p.preg 'pregunta', prc.idResp 'respuestaCorrecta', c.color
FROM pregunta p
         JOIN categoria c ON p.idCat = c.id
         JOIN pregunta_respuesta_correcta prc ON p.id = prc.idPreg
         JOIN estado e ON p.idEst = e.id
WHERE (p.resCor / p.pregTot) BETWEEN 0.7 AND 1
  AND e.descr LIKE 'ACTIVO';

CREATE VIEW cantidadUsuariosPorGenero AS
SELECT CASE
           WHEN u.generoId = 1 THEN 'Masculino'
           WHEN u.generoId = 2 THEN 'Femenino'
           ELSE 'No Especificado'
           END  'sexo',
       COUNT(*) 'cantidad'
FROM usuario u
GROUP BY u.generoId;

CREATE VIEW ranking AS
SELECT u.nombreUsuario, SUM(hp.estado = 1) 'puntaje'
FROM historialPartidas hp
         JOIN usuario u ON hp.idUs = u.id
GROUP BY hp.idUs;

CREATE VIEW dificultadUsuario AS
SELECT h.idUs, SUM(h.estado = 1) / COUNT(*) 'dificultad'
FROM historialpartidas h
GROUP BY h.idUs;

CREATE VIEW obtenerPreguntas AS
SELECT p.id 'preguntaID', p.preg 'pregunta', prc.idResp 'respuestaCorrecta', c.color
FROM pregunta p
         JOIN pregunta_respuesta_correcta prc ON p.id = prc.idPreg
         JOIN categoria c ON p.idCat = c.id
         JOIN estado e ON p.idEst = e.id;
