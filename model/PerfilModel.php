<?php

class PerfilModel
{
    private $database;
    public function __construct($database)
    {
        $this->database = $database;
    }
    public function getPerfilUsuarioPorId($id){

        $sql= "SELECT `id`, `nombre`,`activo`, `nombreUsuario`, `f_nacimiento`, `generoId`, `f_registro`, `fotoPerfil`  FROM usuario  WHERE id='$id' ";
        return $this->database->query($sql);
    }
    public function getPerfilUsuarioPorNombreUsuario($nombreUsuario){
       $sql= "SELECT `id`, `nombre`,`activo`, `nombreUsuario`, `f_nacimiento`, `generoId`, `f_registro`, `fotoPerfil`  FROM usuario  WHERE nombreUsuario='$nombreUsuario' ";
        return $this->database->query($sql);
    }
    public function getPrimerPerfilUsuario(){
        $sql= "SELECT `id`, `nombre`,`activo`, `nombreUsuario`, `f_nacimiento`, `generoId`, `f_registro`, `fotoPerfil`  FROM usuario LIMIT 1";
        return $this->database->query($sql);
    }

    public function obtenerHistorialPartidasUsuario($idUsuario){
        $sql = "SELECT h.n_Partida, h.f_partida, u.nombreUsuario,h.tipoPartida, SUM(estado) AS sumaPreguntasContestadas
                FROM historialPartidas AS h
                JOIN usuario AS u 
                WHERE h.idUs = '$idUsuario'
                GROUP BY h.n_partida, h.idUs";
        return $this->database->query($sql);
    }

    public function getRankingGlobalDelUsuario($idUsuario) {
        $sql= "select ranking from (select ROW_NUMBER() OVER (ORDER BY maximo desc) as ranking, idUs, n_partida, max(puntajeMaximo) as maximo 
from (select idUs, n_partida, count(*) AS puntajeMaximo from historialPartidas  GROUP BY  n_partida, idUs)as sub group by idUs order by maximo desc) as subconsulta where idUs= '$idUsuario';";
        return $this->database->SoloValorCampo($sql);
    }
    public function getMAximoRespuestasCorrectasPorIdUsuario($idUsuario) {
        $sql= "select MAX(contador) as maxRespuetasC from (SELECT idUs, n_partida, COUNT(*) AS contador
    FROM historialPartidas where idUs='$idUsuario' GROUP BY idUs, n_partida) as subconsulta;";
        return $this->database->SoloValorCampo($sql);
    }

}