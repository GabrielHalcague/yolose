<?php

class ReportarModel
{
    private $database;
    public function __construct($database)
    {
        $this->database= $database;
    }

    public function getPregunta($idPregunta){
        $sql= "SELECT p.id, p.preg, c.categ, c.color, FROM pregunta p JOIN categoria c ON p.idCat = c.id where c.id = '$idPregunta'";
        return $this->database->query($sql);
    }
    public function getRespuestasDePregunta($idPRegunta){
        $sql="SELECT * FROM respuesta where idPreg = '$idPRegunta'";
        return $this->database->query($sql);
    }
    public function getRespuestaCorrectaDePregunta($idPRegunta){
        $sql= "SELECT idResp FROM pregunta_respuesta_correcta where idPreg = '$idPRegunta'";
        return $this->database->query($sql);
    }



}