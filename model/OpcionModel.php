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
            $sql = "INSERT INTO respuesta (respuesta, idPreg) VALUES ('$item','$id')";
            $this->database->execute($sql);
        }
    }

    public function obtenerOpcionesDePregunta($id){
        $sql = "SELECT r.id, r.respuesta FROM respuesta r WHERE r.idPreg = '$id'";
        return $this->database->query($sql);
    }

}