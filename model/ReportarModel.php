<?php

class ReportarModel
{
    private $database;
    public function __construct($database)
    {
        $this->database= $database;
    }

    public function getPregunta($id){
        return $this->database->query("SELECT p.id, p.preg, c.categ as 'cat' FROM pregunta p JOIN categoria c ON p.idCat = c.id where p.id = '$id'");
    }
    public function getRespuestasDePregunta($idPRegunta){
        return $this->database->query("SELECT * FROM respuesta where idPreg = '$idPRegunta'");
    }
    public function getRespuestaCorrectaDePregunta($idREspuesta){
        return $this->database->query("SELECT * FROM pregunta_respuesta_correcta where idPreg = '$idREspuesta'");
    }

}