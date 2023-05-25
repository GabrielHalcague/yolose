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

}