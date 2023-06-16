<?php

class AdministradorModel
{
    private $database;
    public function __construct($database)
    {
        $this->database =$database;
    }
    public function getCantidadDeUsuariosNuevosDeEsteMEs(){
        $f_inicio =date('Y-m-01');
        $f_fin=date('Y-m-d');
       return $this->getCantidadDeUsuariosPorFecha($f_inicio, $f_fin);

    }
    public function getCantidadDeUsuariosTotales(){
        $sql ="SELECT count(*) FROM usuario ";
        return $this->database->SoloValorCampo($sql);
    }

    public function getCantidadDeUsuariosPorFecha($f_inicio,$f_fin){
        $sql ="SELECT count(*) FROM usuario WHERE F_registro BETWEEN '$f_inicio' AND '$f_fin';";
        return $this->database->SoloValorCampo($sql);
    }



    //cantidad de partidas jugadas por defecto trae los del mes
    public function getCantidadPartidasJugadasPorFecha( $filtro ='d',$f_inicio = null, $f_fin = null)  {

        $f_inicio = !is_null($f_inicio) ? $f_inicio: date('Y-m-01') ;
        $f_fin = !is_null($f_fin) ? $f_fin: date('Y-m-d') ;


        $sql ="select f_partida, count(distinct(n_partida)) as cantidad from historialpartidas group by f_partida;";
        $tabla= $this->database->query($sql);


        while ($fila = $tabla->fetch_array()){
            $f_partida = $fila['f_partida'];
            $cantidad = $fila['cantidad'];

            // Hacer algo con los valores obtenidos, como almacenarlos en un array
            $array1["ejex"] []= $tabla[0]["f_partida"];
            $array2["ejey"] []= $tabla[0]["cantidad"];

        }

        //$array1["ejex"] []= $tabla[0]["f_partida"];
       // $array2["ejey"] []= $tabla[0]["cantidad"];


        $data["arrays"] = array( $array1["ejex"],$array2["ejey"] );

        return $data;

    }


}