<?php

class RankingModel
{
    private $database;
    public function __construct($database)
    {
        $this->database =$database;
    }
    /*
    public function getTop10PorTipoDePartida($tipo) {
        $sql= "SELECT idUs, u.nombreUsuario, u.fotoPerfil, MAX(repeticiones) AS maximo
FROM ( select idUs, n_partida, count(*) AS repeticiones from historialPartidas where tipoPartida ='$tipo' and estado =1
    GROUP BY idUs, n_partida) AS subconsulta join usuario u on subconsulta.idUs = u.id GROUP BY idUs  LIMIT 10";
            return $this->database->query($sql);
    }*/

        public function getTop10PorTipoDePartida($tipo) {
         $sql= "SELECT u.nombreUsuario, u.fotoPerfil, SUM(hp.estado='$tipo') as puntaje FROM historialPartidas hp
         JOIN usuario u ON hp.idUs = u.id  GROUP BY hp.idUs
                    order by SUM(hp.estado='$tipo') DESC";
        return $this->database->query($sql);
}

}