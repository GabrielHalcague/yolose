<?php

class CategoriaModel{


    private $database;

    public function __construct($database){
        $this->database = $database;
    }

    public function getAllCategories(){
        return $this->database->query("SELECT id, categ FROM categoria");
    }
}