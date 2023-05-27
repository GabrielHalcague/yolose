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


        // si quiermo mostrar las preguntas tengo que llamar a un modelo aparte de preguntas o puedo hacerle estos metodos al modelo?
        public function getPregunta(){
            return $this->database->query('SELECT p.id, p.descripcion, p.categoria, c.descripcion, c.color FROM pregunta p JOIN categoria c ON p.categoria = c.id LIMIT 1');
        }
        public function getRespuestasDePregunta($idPRegunta){
        return $this->database->query("SELECT * FROM opcion where $idPRegunta = $idPRegunta");
        }

}