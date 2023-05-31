<?php

class OpcionModel
{


    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function agregarRespuestas($data, $idPreg){
        $id = $idPreg['id'];
        foreach ( $data as $item) {
            $sql = "INSERT INTO opcion (descripcion, verdadero, idPregunta) VALUES ('$item',0,'$id')";
            $this->database->execute($sql);
        }
    }

    public function obtenerOpcionesDePregunta($idPreg){
        $sql = "SELECT * FROM opcion WHERE idPregunta = $idPreg";
        return $this->database->query($sql);
    }

}