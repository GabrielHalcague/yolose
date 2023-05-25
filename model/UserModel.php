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

}