<?php

class ReportarModel
{
    private $database;
    public function __construct($database)
    {
        $this->database= $database;
    }

    public function getPregunta(){
        return $this->database->query('SELECT p.id, p.descripcion, c.descripcion as "cat" FROM pregunta p JOIN categoria c ON p.categoria = c.id');
    }
    public function getRespuestasDePregunta($idPRegunta){
        return $this->database->query("SELECT * FROM opcion where $idPRegunta = $idPRegunta");
    }

}