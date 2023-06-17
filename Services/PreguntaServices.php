<?php

namespace Services;

class PreguntaServices
{

    private mixed $database;

    public function __construct($database){
        $this->database = $database;
    }

    public function agregarPregunta($data){
        $sql = "INSERT INTO pregunta (preg, idCat, idEst,resCor,pregTot) 
                VALUES ('$data[0]','$data[1]',1,1,2)";
        $this->database->execute($sql);
    }

    public function obtenerIdPregunta($preg){
        $sql = "SELECT id FROM pregunta WHERE preg LIKE '$preg'";
        return $this->database->query($sql);
    }

    public function obtenerTodasLasPreguntas(){
        $sql = "SELECT * FROM obtenerPreguntas";
        return $this->database->query($sql);
    }

    public function obtenerPreguntasDificultadFacil(){
        $sql = "SELECT * FROM dificultadFacil";
        return $this->database->query($sql);
    }

    public function obtenerPreguntasDificultadMedia(){
        $sql = "SELECT * FROM dificultadMedia";
        return $this->database->query($sql);
    }

    public function obtenerPreguntasDificultadDificil(){
        $sql = "SELECT * FROM dificultadDificil";
        return $this->database->query($sql);
    }

    public function obtenerPreguntasReportadas(){
        $sql = "SELECT p.preg, e.descr
                FROM pregunta p JOIN estado e on e.id = p.idEst
                WHERE e.descr LIKE 'REPORTADO' OR e.descr LIKE 'PENDIENTE ACTIVACION'";
        return $this->database->query($sql);
    }

    public function obtenerPreguntasActivas(){
        $sql = "SELECT p.preg, e.descr
                FROM pregunta p JOIN estado e on e.id = p.idEst
                WHERE e.descr LIKE 'ACTIVO'";
        return $this->database->query($sql);
    }

    public function agregarRespuestas($data, $idPreg){
        $id = $idPreg['id'];
        foreach ( $data as $item) {
            $sql = "INSERT INTO respuesta (resp, idPreg) VALUES ('$item','$id')";
            $this->database->execute($sql);
        }
    }

    public function obtenerOpcionesDePregunta($id){
        $sql = "SELECT r.id, r.resp FROM respuesta r WHERE r.idPreg = '$id' ORDER BY RAND()";
        return $this->database->query($sql);
    }
}