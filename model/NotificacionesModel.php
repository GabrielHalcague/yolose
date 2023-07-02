<?php

class notificacionesModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }
    public function getCantidadDEPartidasPendientesPorIdUsuario($idUsuario){
    $sql="select count(*) from historialpvp where idp2= ".$idUsuario." and ganador = '0';";
    return $this->database->SoloValorCampo($sql);

    }


}