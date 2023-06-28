<?php

class RankingModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getTop10PorTipoDePartida($tipo)
    {
        $sql = "select * from (
select distinct (idUs), puntaje from(
select idUs,count(n_partida) as puntaje from historialpartidas where estado= 1 and tipoPartida = ".$tipo." group by n_partida, idUs order by puntaje desc)
as sub group by idUs) as sub2 join usuario where  sub2.idUs = usuario.id order by puntaje desc
            limit 10";
        return $this->database->query($sql);
    }

}