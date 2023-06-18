<?php

class AdministradorUsuarioModel
{
    private $database;
 public function __construct($database)
 {
    $this->database =$database;
 }
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
        $tabla = 'historialCompras';
        $campoFiltro = 'f_compra';
        $campoFiltro2= "cant";
        $operacion= 'sum(cant)';
        $where = "idUs = ".$usuarioId;
        return $this->generarSQLporTablaYCampoConTresColumnas($tabla, $campoFiltro, $campoFiltro2, $operacion , $where, $filtro , $f_inicio , $f_fin );
    }
    public function getPorcentajeDePreguntasRespondidasCorrectamentePorElUsuario( $usuarioId , $filtro, $f_inicio, $f_fin){
        $tabla = 'historialpartidas';
        $campoFiltro = 'f_partida';
        $campoFiltro2= 'estado';
        $operacion= 'COUNT(*) / SUM(COUNT(*)) OVER (PARTITION BY idUs) * 100';
        $where = "idUs = ".$usuarioId;
        $tabla= $this->generarSQLporTablaYCampoConTresColumnas($tabla, $campoFiltro, $campoFiltro2, $operacion , $where, $filtro , $f_inicio , $f_fin );

        foreach ($tabla as &$row) {
            if ($row['descripcion'] === '0') {
                $row['descripcion'] = 'Invalidas';
            } elseif ($row['descripcion'] === '1') {
                $row['descripcion'] = 'Correctas';
            }
        }
        return $tabla;

    }

    public function generarSQLporTablaYCampoConTresColumnas($tabla, $campoFiltro, $campoFiltro2, $operacion , $where, $filtro , $f_inicio , $f_fin ){
        $filtro = !is_null($filtro) ? $filtro : 'd';
        $f_inicio = !is_null($f_inicio) ? $f_inicio : date('Y-m-01');
        $f_fin = !is_null($f_fin) ? $f_fin : date('Y-m-d');
        $operacion = !is_null($operacion) ? $operacion : 'count(*)';

        switch ($filtro){
            case "d":
                $sql= 'select '.$campoFiltro.' as campoFiltro, '.$campoFiltro2.' AS descripcion, '.$operacion.' AS cantidad 
                    from '.$tabla.'  where '.$where.' and '.$campoFiltro.'  between  "'.$f_inicio.'" and "'.$f_fin.'"  group by '.$campoFiltro.','.$campoFiltro2.';';
                break;
            case "m":
                $sql = 'SELECT CONCAT(YEAR('.$campoFiltro.'), "-" , MONTH('.$campoFiltro.')) AS campoFiltro, '.$campoFiltro2.' AS descripcion, '.$operacion.' AS cantidad
        FROM '.$tabla.' WHERE '.$where.' and '.$campoFiltro.' BETWEEN "'.$f_inicio.'" AND "'.$f_fin.'"  
        GROUP BY CONCAT(YEAR('.$campoFiltro.'), "-", MONTH('.$campoFiltro.')) , '.$campoFiltro2.';';
                break;

            case "y":
                $sql= 'SELECT YEAR('.$campoFiltro.') AS campoFiltro, '.$campoFiltro2.' AS descripcion, '.$operacion.'  AS cantidad FROM '.$tabla.' 
                where '.$where.' and '.$campoFiltro.'  between  "'.$f_inicio.'" and "'.$f_fin.'"  group BY YEAR('.$campoFiltro.') , '.$campoFiltro2.';';
                break;
        }
        return $this->database->query($sql);
    }

}