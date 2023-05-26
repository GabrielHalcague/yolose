<?php

class PerfilModel
{
    private $database;
    public function __construct($database)
    {
        $this->database = $database;
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
}