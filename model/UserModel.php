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
        return $this->database->query("SELECT * FROM usuario
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
                       g.descr 
                FROM usuario u JOIN genero g ON u.generoId = g.id
                WHERE u.nombreUsuario = '$username'";
        return $this->database->query($sql);
    }

    public function getUsuarioByID($id){
        $sql = "SELECT u.id ,u.nombre, u.apellido, u.correo, u.password, u.activo, u.nombreUsuario, u.f_nacimiento, f_registro, fotoPerfil, descr 
                FROM usuario u JOIN genero g ON u.generoId = g.id
                WHERE u.id = '$id'";
        return $this->database->query($sql);
    }

}
