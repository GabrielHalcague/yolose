<?php

class TiendaModel
{

    private $getDatabase;

    public function __construct($database)
    {

        $this->database = $database;
    }

    public function registroPago($array){
        $this->actualizaTrampasUsuario($array['item']['cantidad'],$array['idusuario']);
        $this->agregarInformacionDeCompra([
            'idUsuario' => $array['idusuario'],
            'idTrampa' => $array['item']['idTrampa'],
            'cantidad' => $array['item']['cantidad']
        ]);
    }

    private function actualizaTrampasUsuario($cantTrampasTotales, $idUsuario)
    {
        $sql = "UPDATE usuario u SET u.trampas = u.trampas + $cantTrampasTotales WHERE id = $idUsuario";
        $this->database->execute($sql);
    }

    private function agregarInformacionDeCompra($data){
        $idUs = $data['idUsuario'];
        $idTrampa = $data['idTrampa'];
        $cantidad = $data['cantidad'];
        $sql = "INSERT INTO historialCompras(cant, idUs, idTr) 
                VALUES ('$cantidad','$idUs','$idTrampa')";
        $this->database->execute($sql);
    }

    public function obtenerTodasLasTrampas()
    {
        $sql = "SELECT * FROM trampa";
        return $this->database->query($sql);
    }

    public function obtenerTrampaPorDescripcion($des)
    {
        $sql = "SELECT * FROM trampa where descr = '$des'";
        return $this->database->query_row($sql);
    }

    public function obtenerTrampaPorId($id)
    {
        $sql = "SELECT * FROM trampa where idTrampa = '$id'";
        return $this->database->query_row($sql);
    }

    public function getUsuarioByID($id){
        $sql = "SELECT nombre, apellido, CONCAT(nombre,' ', apellido) as 'nombreCompleto', correo
                FROM usuario
                WHERE id = '$id'";
        return $this->database->query_row($sql);
    }
}