<?php

class PreguntaModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }
    
    public function insertarPregunta($datosDePregunta,$idUsuario){
        $idPregunta= $this->obtenerIdPregunta($datosDePregunta['pregunta']);
        if($idPregunta==0){
            $this->agregarPregunta([$datosDePregunta['pregunta'], $datosDePregunta['categoria']],$idUsuario);
            $idPregunta= $this->obtenerIdPregunta($datosDePregunta['pregunta']);
            $this->agregarRespuestas($datosDePregunta, $idPregunta);
            $idRespCorrecta= $this->obtenerIdRespuestaCorrecta($datosDePregunta['opcionA'],$idPregunta);
            $this->insertarPreguntaRespuestaCorrecta($idPregunta,$idRespCorrecta);
        }
    }

    public function agregarPregunta($data,$idUsuario){
        $sql = "INSERT INTO pregunta (preg, idCat, idEst,resCor,pregTot, idUsuario)
                VALUES ('$data[0]','$data[1]',1,1,2,'$idUsuario')";
        $this->database->execute($sql);
    }

    public function obtenerIdPregunta($preg){
        $sql = "SELECT id FROM pregunta WHERE preg LIKE '$preg'";
       $result= $this->database->query_row($sql);
       if($result!=null){
           return $result['id'];
       }
       return 0;
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
        $id = $idPreg;
        $opcA=$data['opcionA'];
        $opcB=$data['opcionB'];
        $opcC=$data['opcionC'];
        $opcD=$data['opcionD'];
            $sql = "INSERT INTO respuesta (resp, idPreg)
                VALUES ('$opcA','$id'),('$opcB','$id'),('$opcC','$id'),('$opcD','$id')";
            $this->database->execute($sql);
    }
    
    public function obtenerIdRespuestaCorrecta($resp, $idPregunta){
        $sql = "SELECT id from respuesta r where r.resp= '$resp' and r.idPreg= '$idPregunta'";
        $result= $this->database->query_row($sql);
        return $result['id'];
    }
    public function insertarPreguntaRespuestaCorrecta($idPregunta,$idRespCorrecta){
        $sql= "INSERT INTO pregunta_respuesta_correcta(idPreg,idResp) values ('$idPregunta','$idRespCorrecta')";
        $this->database->execute($sql);
    }
}