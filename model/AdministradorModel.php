<?php

class AdministradorModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getCantidadDeUsuariosTotales()
    {
        $sql = "SELECT count(*) FROM usuario ";
        return $this->database->SoloValorCampo($sql);
    }

    public function getCantidadDeUsuariosPorFecha($f_inicio, $f_fin)
    {
        $sql = "SELECT count(*) FROM usuario WHERE F_registro BETWEEN '$f_inicio' AND '$f_fin';";
        return $this->database->SoloValorCampo($sql);
    }

    public function getCantidadDeUsuariosPorSexo($filtro, $f_inicio, $f_fin)
    {
       $campoFiltro="u.f_registro";
        $array = $this->arrayFiltroFechas($filtro,$campoFiltro ,$f_inicio,$f_fin);

        $sql= "select  ".$array['select']."  g.descr AS descripcion, count(g.descr) AS cantidad 
                    from usuario u join genero g on u.generoId = g.id  where u.f_registro  between ".$array['between']." group by ".$array['groupby']." ,g.descr;";
        return  $this->EjecutarConsulta($sql);
    }


    public function getCantidadDeTrampasVendidasPorFecha($filtro = 'd', $f_inicio = null, $f_fin = null)
    {
        $campoFiltro="f_compra";
        $array = $this->arrayFiltroFechas($filtro,$campoFiltro ,$f_inicio,$f_fin);
        $sql= "select ".$array['select']."  'Trampas' AS descripcion, sum(cant) AS cantidad 
                    from historialcompras where ".$campoFiltro."  between ".$array['between']." group by ".$array['groupby'].";";
        return  $this->EjecutarConsulta($sql);
    }

    public function getCantidadDePreguntasDisponiblesPorFecha($filtro = 'd', $f_inicio = null, $f_fin = null)
    {
        $campoFiltro="p.f_creacion";
        $array = $this->arrayFiltroFechas($filtro,$campoFiltro ,$f_inicio,$f_fin);
        $sql= "select ".$array['select']."  e.descr as descripcion, COUNT(*) AS cantidad from pregunta p join estado e on p.idEst = e.id 
                            where ".$campoFiltro."  between ".$array['between']." group by ".$array['groupby'].", descripcion;";
        return  $this->EjecutarConsulta($sql);
    }

    public function getCantidadPartidasJugadasPorFecha($filtro = 'd', $f_inicio = null, $f_fin = null)
    {
        $campoFiltro="f_partida";
        $array = $this->arrayFiltroFechas($filtro,$campoFiltro ,$f_inicio,$f_fin);
        $sql= "select ".$array['select']." t.descripcion AS descripcion, COUNT(distinct(n_partida)) AS cantidad 
                    from historialpartidas h join tipopartida t on h.tipoPartida = t.id  
                     where ".$campoFiltro."  between ".$array['between']." group by ".$array['groupby'].", t.descripcion;";
        return  $this->EjecutarConsulta($sql);
    }

    public function getCantidadPartidasJugadasEsteMEs()
    {
        $datos = $this->getCantidadPartidasJugadasPorFecha('m');
        return $datos["arrays"][1][0];
    }

    public function getCantidadDePreguntasEnElJuegoPorFecha($filtro = 'd', $f_inicio = null, $f_fin = null)
    {
        $campoFiltro="f_creacion";
        $array = $this->arrayFiltroFechas($filtro,$campoFiltro ,$f_inicio,$f_fin);
        $sql= "select ".$array['select']." 'preguntas' AS descripcion, count(*) AS cantidad from pregunta 
                 where ".$campoFiltro."  between ".$array['between']." group by ".$array['groupby'].";";
        return  $this->EjecutarConsulta($sql);

    }

    public function getCantidadDeUsuariosNuevosPorFecha($filtro = 'd', $f_inicio = null, $f_fin = null)
    {
        $campoFiltro="f_registro";
        $array = $this->arrayFiltroFechas($filtro,$campoFiltro ,$f_inicio,$f_fin);
        $sql= "select ".$array['select']."'usuarios' AS descripcion, COUNT(*) AS cantidad from usuario 
                      where ".$campoFiltro."  between ".$array['between']." group by ".$array['groupby'].";";
        return  $this->EjecutarConsulta($sql);

    }

    public function getCantidadDeUsuariosPorRangoDeEdad($filtro = 'd', $f_inicio = null, $f_fin = null)
    {
        $campoFiltro="f_registro";
        $array = $this->arrayFiltroFechas($filtro,$campoFiltro ,$f_inicio,$f_fin);
        $sql= "select ".$array['select']." rango_edad AS descripcion, COUNT(rango_edad) AS cantidad 
                    from ( SELECT f_registro,   CASE
            WHEN TIMESTAMPDIFF(YEAR, f_nacimiento, CURDATE()) < 30 THEN 'Joven'
            WHEN TIMESTAMPDIFF(YEAR, f_nacimiento, CURDATE()) BETWEEN 30 AND 60 THEN 'Edad Media'
            ELSE 'Adulto' END AS rango_edad  FROM   usuario) AS subconsulta  
            where ".$campoFiltro."  between ".$array['between']." group by ".$array['groupby'].", rango_edad;";
        return  $this->EjecutarConsulta($sql);
    }


////////////////////////////////// USUARIO//////////////////////////////////
    public function getDatosDelUsuario($username){
        $sql = "SELECT u.id,
                       u.nombre,
                       u.apellido,
                       u.correo,
                       u.password,
                       u.activo,
                       u.nombreUsuario,
                       u.f_nacimiento,
                       u.f_registro,
                       u.fotoPerfil,
                       u.coordenadas,
                       g.descr,
                       r.descr 'rol'
                FROM usuario u JOIN genero g ON u.generoId = g.id
                               JOIN rol_usuario ru on u.id = ru.idUs
                               JOIN rol r on r.id = ru.idRol
                WHERE u.nombreUsuario = '$username'";
        return $this->database->query_row($sql);
    }

    public function getTrampitasAcumuladasPorElUsuario($usuarioId ,$filtro, $f_inicio, $f_fin){
        $campoFiltro="f_compra";
        $array = $this->arrayFiltroFechas($filtro,$campoFiltro ,$f_inicio,$f_fin);

        $sql= "select ".$array['select']." 'Trampas' AS descripcion, sum(cant) AS cantidad 
                    from historialCompras  where idUs = ".$usuarioId." and ".$campoFiltro."  between  ".$array['between']."  group by ".$array['groupby'].";";

        return  $this->EjecutarConsulta($sql);
    }
    public function getPorcentajeDePreguntasRespondidasCorrectamentePorElUsuario( $usuarioId , $filtro, $f_inicio, $f_fin){

        $campoFiltro="f_partida";
        $array = $this->arrayFiltroFechas($filtro,$campoFiltro ,$f_inicio,$f_fin);

       $sql= "select ".$array['select']."CASE estado
                                                   WHEN 0 THEN 'Incorrecta'
                                                   WHEN 1 THEN 'Correcta'
       END AS descripcion, (COUNT(*) / SUM(COUNT(*)) OVER (PARTITION BY idUs) * 100) AS cantidad
                from historialpartidas  where idUs =".$usuarioId." and ".$campoFiltro."  between ".$array['between']." group by ".$array['groupby'].",estado;";
        return  $this->EjecutarConsulta($sql);

    }

    ///////////////////////////// ///////////////////////////////////////////////////
    public function arrayFiltroFechas($filtro ,$campoFiltro, $f_inicio, $f_fin): array
    {
        $filtro = !is_null($filtro) ? $filtro : 'd';
        $f_inicio = !is_null($f_inicio) ? $f_inicio : date('Y-m-01');
        $f_fin = !is_null($f_fin) ? $f_fin : date('Y-m-d');
        $array=[];
        switch ($filtro){
            case "y":
                $array['select'] = "(YEAR(".$campoFiltro.")) AS campoFiltro,";
                $array['between'] = "'".$f_inicio."' AND '".$f_fin."'" ;
                $array['groupby'] = "(YEAR(".$campoFiltro."))";
                break;
            case "m":
                //GROUP BY CONCAT(YEAR(f_compra), "-", MONTH(f_compra)) , cant;"
                $array['select'] = "CONCAT(YEAR(".$campoFiltro."), '-' , MONTH(".$campoFiltro.")) AS campoFiltro,";
                $array['between'] = "'".$f_inicio."' AND '".$f_fin."'" ;
                $array['groupby'] = "CONCAT(YEAR(".$campoFiltro."), '-' , MONTH(".$campoFiltro."))";
                break;

            default :
                $array['select'] = $campoFiltro." AS campoFiltro,";
                $array['between'] = "'".$f_inicio."' AND '".$f_fin."'" ;
                $array['groupby'] = $campoFiltro ;
                break;
        }
        return $array;

    }


    public function EjecutarConsulta($sql): array
    {
        $tabla = $this->database->query($sql);
        if (empty($tabla)) {
            $tabla[] = [
                "campoFiltro" => "sin datos",
                "descripcion" => " sin datos",
                "cantidad" => 0
            ];
            return $tabla;
        }else
            return $tabla;
    }


    public function getCantidadDeUsuariosPorPais($filtro = 'd', $f_inicio = null, $f_fin = null)    {
        $arrayCoordenadas = $this->obtenerCoordenadasDeTodosLosUsuarios($f_inicio, $f_fin);
        $arrayPaises=[];

        foreach ($arrayCoordenadas as $row) {
                $separado = explode(",",$row['coordenadas']);
                $latitud = trim($separado[0]);
                $longitud = trim($separado[1]);
                $pais = $this->obtenerPaisPorCoordenadas($latitud,$longitud);
            $encontrado = false;
            foreach ($arrayPaises as &$dato) {
                if ($dato['campoFiltro'] == $pais) {
                    $dato['cantidad'] ++;
                    $encontrado = true;
                    break;
                }
            }
            if (!$encontrado) {
                $arrayAUX = array(
                    "campoFiltro" => $pais,
                    "descripcion" => $pais,
                    "cantidad" => 1
                );
                array_push($arrayPaises, $arrayAUX);
            }
        }
        return $arrayPaises;
    }

    private function obtenerCoordenadasDeTodosLosUsuarios($f_inicio = null, $f_fin = null){
        $sql = "SELECT coordenadas FROM usuario WHERE f_registro BETWEEN '$f_inicio' AND '$f_fin' limit 10";
        return $this->database->query($sql);
    }

    private function obtenerPaisPorCoordenadas($latitud, $longitud) {
        $USERAGENT = $_SERVER['HTTP_USER_AGENT'];
        $opts = array('http'=>array('header'=>"User-Agent: $USERAGENT\r\n"));
        $context = stream_context_create($opts);
        $response = file_get_contents("https://nominatim.openstreetmap.org/reverse?format=json&lat=$latitud&lon=$longitud&zoom=18&addressdetails=1", false, $context);
        $data = json_decode($response, true);

        if(isset($data['address']['country'])) {
            return $data['address']['country'];
        } else {
            return 'País no encontrado';
        }
    }

}