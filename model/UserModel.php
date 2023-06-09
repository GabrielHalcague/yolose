<?php

class UserModel{

    private $database;

    public function __construct($database){
        $this->database = $database;
    }

    public function getGenderByID($genderId){
        $sql = "SELECT * FROM genero WHERE id = $genderId";
        return $this->database->query($sql);
    }
    public function getUsuarioByEmail($mail, $password)
    {
        $password = hash('md5', $password);
        $sql= "SELECT * FROM usuario  WHERE correo='$mail' AND password='$password'";
        return $this->database->query($sql);
    }

    public function getUsuario($nickname, $password)
    {
        $password = hash('md5', $password);
        return $this->database->query_row("SELECT u.id,u.nombreUsuario, u.activo, r.descr 'rol' FROM usuario u
                                       JOIN rol_usuario ru on u.id = ru.idUs
                                       JOIN rol r on r.id = ru.idRol
                                       WHERE nombreUsuario='$nickname'
                                       AND password='$password'");
    }

    public function getUsuarioByUsername($username){
        $sql = "SELECT u.id,
                       u.nombre,
                       u.apellido,
                       u.correo,
                       u.password,
                       u.activo,
                       u.nombreUsuario,
                       u.f_nacimiento,
                       u.f_registro,
                       u.fotoPerfil,
                       u.coordenadas,
                       g.descr,
                       r.descr 'rol'
                FROM usuario u JOIN genero g ON u.generoId = g.id
                               JOIN rol_usuario ru on u.id = ru.idUs
                               JOIN rol r on r.id = ru.idRol
                WHERE u.nombreUsuario = '$username'";
        return $this->database->query_row($sql);
    }

    public function getUsuarioByID($id){
        $sql = "SELECT u.id ,u.nombre, u.apellido, u.correo, u.password, u.activo, u.nombreUsuario, u.f_nacimiento, f_registro, fotoPerfil, descr 
                FROM usuario u JOIN genero g ON u.generoId = g.id
                WHERE u.id = '$id'";
        return $this->database->query_row($sql);
    }

    public function obtenerHistorialPartidasUsuario($idUsuario){
        $sql = "SELECT h.n_Partida, u.nombreUsuario,h.tipoPartida, SUM(estado) AS sumaPreguntasContestadas
                FROM historialpartidas AS h
                JOIN usuario AS u 
                WHERE h.idUs = '$idUsuario'
                GROUP BY h.n_partida, h.idUs";
        return $this->database->query($sql);
    }
}
