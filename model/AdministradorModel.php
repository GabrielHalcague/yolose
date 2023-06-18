<?php

class AdministradorModel
{
    private $database;
    public function __construct($database)
    {
        $this->database =$database;
    }

    public function getCantidadDeUsuariosTotales(){
        $sql ="SELECT count(*) FROM usuario ";
        return $this->database->SoloValorCampo($sql);
    }

    public function getCantidadDeUsuariosPorFecha($f_inicio,$f_fin){
        $sql ="SELECT count(*) FROM usuario WHERE F_registro BETWEEN '$f_inicio' AND '$f_fin';";
        return $this->database->SoloValorCampo($sql);
    }

    public function getCantidadDeUsuariosPorSexo($filtro,$f_inicio,$f_fin){
        $tabla = 'usuario u join genero g on u.generoId = g.id';
        $campoFiltro = 'u.f_registro';
        $campoFiltro2="g.descr";
        $operacion= 'count(g.descr)';
        $tabla = $this->generarSQLporTablaYCampoConTresColumnas($tabla, $campoFiltro, $campoFiltro2, $operacion , $filtro , $f_inicio , $f_fin );
        return $tabla;
    }


    public function getCantidadGananciaDeTrampasVendidasPorFecha($filtro ='d', $f_inicio = null, $f_fin = null)
    {
        $tabla = 'historialcompras';
        $campoFiltro = 'f_compra';
        $count = 'SUM(cant)';
        $tabla = $this->generarSQLporTablaYCampo($tabla, $campoFiltro, $count, $filtro, $f_inicio, $f_fin);
        return $this->regresoDeArrayConEjes($tabla);
    }

    public function getCantidadDePreguntasDisponiblesPorFecha($filtro ='d', $f_inicio = null, $f_fin = null)
    {
        $tabla = 'pregunta p join estado e on p.idEst = e.id';
        $campoFiltro = 'p.f_creacion';
        $operacion= 'COUNT(*)';
        $tabla = $this->generarSQLporTablaYCampo($tabla, $campoFiltro, $operacion, $filtro, $f_inicio, $f_fin);
        return $this->regresoDeArrayConEjes($tabla);

    }


    public function getCantidadPartidasJugadasPorFecha( $filtro ='d', $f_inicio = null, $f_fin = null)
    {
        $tabla = 'historialpartidas h join tipopartida t on h.tipoPartida = t.id';
        $campoFiltro = 'f_partida';
        $campoFiltro2= "t.descripcion";
        $operacion = 'COUNT(distinct(n_partida))';
        $tabla = $this->generarSQLporTablaYCampoConTresColumnas($tabla, $campoFiltro, $campoFiltro2, $operacion , $filtro , $f_inicio , $f_fin );
        return $tabla;

    }

    public function getCantidadPartidasJugadasEsteMEs(){
        $datos = $this->getCantidadPartidasJugadasPorFecha('m');
        return $datos["arrays"][1][0];
    }

    public function getCantidadDePreguntasEnElJuegoPorFecha( $filtro ='d', $f_inicio = null, $f_fin = null)
    {
        $tabla ='pregunta';
        $campoFiltro='f_creacion';
        $operacion= null;
        $tabla = $this->generarSQLporTablaYCampo($tabla,$campoFiltro,$operacion, $filtro, $f_inicio, $f_fin);
        return $this->regresoDeArrayConEjes($tabla);
    }

    public function getCantidadDeUsuariosNuevosPorFecha($filtro ='d', $f_inicio = null, $f_fin = null)
    {
        $tabla ='usuario';
        $campoFiltro='f_registro';
        $operacion='COUNT(*)';
        $tabla = $this->generarSQLporTablaYCampo($tabla,$campoFiltro,$operacion , $filtro, $f_inicio, $f_fin);
        return $this->regresoDeArrayConEjes($tabla);

    }

    public function getCantidadDeUsuariosPorRangoDeEdad($filtro ='d', $f_inicio = null, $f_fin = null)
    {
        $tabla = '(
    SELECT
        f_registro,
        CASE
            WHEN TIMESTAMPDIFF(YEAR, f_nacimiento, CURDATE()) < 30 THEN "Joven"
            WHEN TIMESTAMPDIFF(YEAR, f_nacimiento, CURDATE()) BETWEEN 30 AND 60 THEN "Edad Media"
            ELSE "Adulto"        END AS rango_edad    FROM        usuario) AS subconsulta';
        $campoFiltro = 'f_registro';
        $campoFiltro2= "rango_edad";
        $operacion = 'COUNT(rango_edad)';
        $tabla = $this->generarSQLporTablaYCampoConTresColumnas($tabla, $campoFiltro, $campoFiltro2, $operacion , $filtro , $f_inicio , $f_fin );
        return $tabla;

    }

    public function generarSQLporTablaYCampo($tabla, $campoFiltro, $operacion , $filtro , $f_inicio , $f_fin ){
        $filtro = !is_null($filtro) ? $filtro : 'd';
        $f_inicio = !is_null($f_inicio) ? $f_inicio : date('Y-m-01');
        $f_fin = !is_null($f_fin) ? $f_fin : date('Y-m-d');
        $operacion = !is_null($operacion) ? $operacion : 'count(*)';

        switch ($filtro){
            case "d":
                $sql= 'select '.$campoFiltro.' as fecha, '.$operacion.' AS cantidad 
                    from '.$tabla.'  where '.$campoFiltro.'  between  "'.$f_inicio.'" and "'.$f_fin.'"  group by '.$campoFiltro.';';
                break;
            case "m":
                $sql = 'SELECT CONCAT(YEAR('.$campoFiltro.'), "-" , MONTH('.$campoFiltro.')) AS fecha, '.$operacion.' AS cantidad
        FROM '.$tabla.' WHERE '.$campoFiltro.' BETWEEN "'.$f_inicio.'" AND "'.$f_fin.'"  
        GROUP BY CONCAT(YEAR('.$campoFiltro.'), "-", MONTH('.$campoFiltro.'));';
                break;

            case "y":
                $sql= 'SELECT YEAR('.$campoFiltro.') AS fecha, '.$operacion.'  AS cantidad FROM '.$tabla.' 
                where '.$campoFiltro.'  between  "'.$f_inicio.'" and "'.$f_fin.'"  group BY YEAR('.$campoFiltro.');';
                break;
        }
        return $this->database->query($sql);
    }
    public function generarSQLporTablaYCampoConTresColumnas($tabla, $campoFiltro, $campoFiltro2, $operacion , $filtro , $f_inicio , $f_fin ){
        $filtro = !is_null($filtro) ? $filtro : 'd';
        $f_inicio = !is_null($f_inicio) ? $f_inicio : date('Y-m-01');
        $f_fin = !is_null($f_fin) ? $f_fin : date('Y-m-d');
        $operacion = !is_null($operacion) ? $operacion : 'count(*)';

        switch ($filtro){
            case "d":
                $sql= 'select '.$campoFiltro.' as campoFiltro, '.$campoFiltro2.' AS descripcion, '.$operacion.' AS cantidad 
                    from '.$tabla.'  where '.$campoFiltro.'  between  "'.$f_inicio.'" and "'.$f_fin.'"  group by '.$campoFiltro.','.$campoFiltro2.';';
                break;
            case "m":
                $sql = 'SELECT CONCAT(YEAR('.$campoFiltro.'), "-" , MONTH('.$campoFiltro.')) AS campoFiltro, '.$campoFiltro2.' AS descripcion, '.$operacion.' AS cantidad
        FROM '.$tabla.' WHERE '.$campoFiltro.' BETWEEN "'.$f_inicio.'" AND "'.$f_fin.'"  
        GROUP BY CONCAT(YEAR('.$campoFiltro.'), "-", MONTH('.$campoFiltro.')) , '.$campoFiltro2.';';
                break;

            case "y":
                $sql= 'SELECT YEAR('.$campoFiltro.') AS campoFiltro, '.$campoFiltro2.' AS descripcion, '.$operacion.'  AS cantidad FROM '.$tabla.' 
                where '.$campoFiltro.'  between  "'.$f_inicio.'" and "'.$f_fin.'"  group BY YEAR('.$campoFiltro.') , '.$campoFiltro2.';';
                break;
        }
        return $this->database->query($sql);
    }

    public function regresoDeArrayConEjes($tabla){
        $matriz=[];
        if(count($tabla)>0){
            foreach ($tabla as $fila) {
                $datosTabla= array(
                    "campoFiltro" => $fila["fecha"],
                    "descripcion" => "",
                    "cantidad" => $fila["cantidad"]
                );
            array_push($matriz,$datosTabla);
            }
        }else{
            $matriz [] = array('sin datos' => array(array('0' => 0)));
        }
        return $matriz;
    }





}