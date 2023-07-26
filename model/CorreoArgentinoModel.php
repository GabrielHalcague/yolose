<?php

class CorreoArgentinoModel
{
    private $database;
    public function __construct($database)
    {
        $this->database= $database;
    }
        public function getTop10(){
            $sql = " select u.nombreUsuario, u.fotoPerfil, count(*) as puntaje , hp.n_partida
                from historialpartidas hp join usuario u on u.id = hp.idUs
            where hp.estado = 1
            group by hp.n_partida, u.nombreUsuario
            order by  count(*) desc
            limit 3";
            return $this->database->query($sql);
        }
        
}