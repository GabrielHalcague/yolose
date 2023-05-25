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

    public function getUsuario($nickname, $password)
    {
        $password = hash('md5', $password);
        return $this->database->query("SELECT * FROM usuario
                                       WHERE nombreUsuario='$nickname'
                                       AND password='$password'");
    }

}