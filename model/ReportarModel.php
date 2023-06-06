<?php

class ReportarModel
{
    private $database;
    public function __construct($database)
    {
        $this->database= $database;
    }

    public function getPregunta(){
        return $this->database->query('SELECT p.id, p.pregunta, c.categoria as "cat" FROM pregunta p JOIN categoria c ON p.idCat = c.id');
    }
    public function getRespuestasDePregunta($idPRegunta){
        return $this->database->query("SELECT * FROM respuesta where idPreg = $idPRegunta");
    }

}