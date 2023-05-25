<?php

class ReportarModel
{
    private $database;
    public function __construct($database)
    {
        $this->database= $database;
    }

    public function getPregunta(){
        return $this->database->query('SELECT p.id, p.descripcion, p.categoria, c.descripcion as "categoria", c.color, c.campaña as "campana" FROM pregunta p JOIN categoria c ON p.categoria = c.id LIMIT 1');
    }
    public function getRespuestasDePregunta($idPRegunta){
        return $this->database->query("SELECT * FROM opcion where $idPRegunta = $idPRegunta");
    }

}