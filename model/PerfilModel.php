<?php

class PerfilModel
{
    private $database;
    public function __construct($database)
    {
        $this->database = $database;
    }

    public function obtenerCoordenadas($username){
        $sql = "SELECT coordenadas from usuario u WHERE u.nombreUsuario = '$username'";
        $result = $this->database->query_row($sql)['coordenadas'];
        Logger::error("COORDENADAS OBTENIDAS: ". $result);
        return $result ;
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
        $sql = " select hp.f_partida, u.nombreUsuario,
            count(*) as sumaPreguntasContestadas , hp.n_partida,t.descripcion
                from historialPartidas hp join usuario u on u.id = hp.idUs
                join tipoPartida t on t.Id = hp.tipoPartida
            where hp.estado = 1 and hp.idUs= '$idUsuario'
            group by hp.n_partida, u.nombreUsuario
            order by  count(hp.f_partida) desc";
        return $this->database->query($sql);
    }

    private function rankingGeneral(){

        $sql = " select u.id, u.nombreUsuario, count(*) as puntaje , hp.n_partida
                from historialPartidas hp join usuario u on u.id = hp.idUs
            where hp.estado = 1
            group by hp.n_partida, u.nombreUsuario
            order by  count(*) desc
            limit 10";
        return $this->database->query($sql);
    }

    public function getRankingGlobalDelUsuario($idUsuario) {
        $data= $this->rankingGeneral();
        $posicion=array_search($idUsuario, array_column($data,'id') )+1;
        return $posicion;
    }
    public function getMAximoRespuestasCorrectasPorIdUsuario($idUsuario) {
        $sql= "select MAX(contador) as maxRespuetasC from (SELECT idUs, n_partida, COUNT(*) AS contador
                FROM historialPartidas hp where idUs='$idUsuario' and hp.estado=1
                GROUP BY idUs, n_partida) as subconsulta";
        return $this->database->SoloValorCampo($sql);
    }

}