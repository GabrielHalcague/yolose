<?php

class PreguntaModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function agregarPregunta($data){
        $sql = "INSERT INTO pregunta (descripcion, categoria, cantidadDeReportes) 
                VALUES ('$data[0]','$data[1]',0)";
        $this->database->execute($sql);
    }

    public function obtenerIdPregunta($preg){
        $sql = "SELECT id FROM pregunta WHERE descripcion LIKE '$preg'";
        return $this->database->query($sql);
    }

    public function obtenerTodasLasPreguntas(){
        $sql = "SELECT p.id, p.descripcion 'pregunta', c.descripcion as 'categoria', c.color  FROM pregunta p JOIN categoria c ON p.categoria = c.id";
       /* $sql = "SELECT *  FROM pregunta";*/
        return $this->database->query($sql);
    }
}