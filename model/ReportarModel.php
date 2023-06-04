<?php

class ReportarModel
{
    private $database;

    public function __construct($database)
    {
        $this->database= $database;
    }

    public function obtenerPreguntas(){
        $listadoPreguntas = $this->obtenerTodasLasPreguntas();



    }

    public function obtenerPreguntasActivas(){
        return $this->preguntaModel->obtenerPreguntasActivas();
    }
    /*public function getRespuestasDePregunta($idPRegunta){
        return $this->database->query("SELECT * FROM respuesta where idPreg = $idPRegunta");
    }*/

    private function obtenerTodasLasPreguntas(){
        $sql = "SELECT p.preg, e.descr 'estado' 
                FROM pregunta p JOIN estado e ON p.idEst = e.id
                WHERE e.descr NOT LIKE 'ACTIVO'";
        return $this->database->query($sql);
    }

}