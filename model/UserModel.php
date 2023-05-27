<?php

class UserModel{

    private $database;

    public function __construct($database){
        $this->database = $database;
    }

    public function getGenderByID($genderId){
        $sql = "SELECT * FROM genero WHERE generoId = $genderId";
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
        $sql = "SELECT nombre, apellido, correo, password, activo, nombreusuario, f_nacimiento, f_registro, fotoperfil, descripcion 
                FROM usuario u JOIN genero g ON u.generoId = g.generoId
                WHERE u.nombreUsuario = '$username'";
        return $this->database->query($sql);
    }

}
