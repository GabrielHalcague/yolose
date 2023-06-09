<?php

class RankingModel
{
    private $database;
    public function __construct($database)
    {
        $this->database =$database;
    }
    public function getTop10PorTipoDePartida($tipo) {
        $sql= "SELECT idUs, u.nombreUsuario, u.fotoPerfil, MAX(repeticiones) AS maximo
FROM ( select idUs, n_partida, count(*) AS repeticiones from historialpartidas where tipoPartida =$tipo
    GROUP BY idUs, n_partida) AS subconsulta join usuario u on subconsulta.idUs = u.id GROUP BY idUs ORDER BY repeticiones DESC LIMIT 10";
            return $this->database->query($sql);
    }
}