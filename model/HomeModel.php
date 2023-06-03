<?php

class HomeModel
{
    private $database;
    public function __construct($database)
    {
        $this->database= $database;
    }
        public function getTop10(){
            return $this->database->query('SELECT * FROM top10');
        }

        /*public function getPregunta(){
            return $this->database->query('SELECT p.id, p.descripcion, c.descripcion, c.color FROM pregunta p JOIN categoria c ON p.categoria = c.id LIMIT 1');
        }
        public function getRespuestasDePregunta($idPRegunta){
        return $this->database->query("SELECT * FROM opcion where $idPRegunta = $idPRegunta");
        }*/

}