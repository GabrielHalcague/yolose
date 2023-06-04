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
            $sql = "INSERT INTO respuesta (resp, idPreg) VALUES ('$item','$id')";
            $this->database->execute($sql);
        }
    }

    public function obtenerOpcionesDePregunta($id){
        $sql = "SELECT r.id, r.resp FROM respuesta r WHERE r.idPreg = '$id' ORDER BY RAND()";
        return $this->database->query($sql);
    }

}