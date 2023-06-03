<?php
require_once 'model/UserModel.php';
require_once 'model/PreguntaModel.php';
require_once 'model/UserModel.php';

class PartidaModel{

    private mixed $database;
    private mixed $usuarioModel;
    private mixed$preguntaModel;
    private mixed $opcionModel;

    public function __construct($database, $models)
    {
        $this->database = $database;
        $this->preguntaModel = $models['pregunta'];
        $this->opcionModel = $models['opcion'];
        $this->usuarioModel = $models['usuario'];
    }

    public function obtenerPreguntas($username){
        $usuario = $this->usuarioModel->getUsuarioByUsername($username)[0];
        $dificultadUsuario = $this->obtenerDificultadUsuario($usuario['id']);
        $arrayPreguntas = [];
        if(empty($dificultadUsuario)){
            $arrayPreguntas = $this->preguntaModel->obtenerPreguntasDificultadMedia();
        }else {
            $dif = $dificultadUsuario[0]['dificultad'];
            if ($dif >= 0 && $dif <= 0.3) {
                $arrayPreguntas = $this->obtenerPreguntasDificultadDificil($usuario['id']);
            } else if ($dif > 0.3 && $dif <= 0.7) {
                $arrayPreguntas = $this->obtenerPreguntasDificultadMedia($usuario['id']);
            } else {
                $arrayPreguntas = $this->obtenerPreguntasDificultadFacil($usuario['id']);
            }
        }
        return $arrayPreguntas;
    }

    private function obtenerDificultadUsuario($id){
        $sql = "SELECT * FROM dificultadUsuario WHERE idUs = $id";
        return $this->database->query($sql);
    }

    public function obtenerRespuestaDePregunta($id){
        return $this->opcionModel->obtenerOpcionesDePregunta($id);
    }

    private function obtenerPreguntasDificultadMedia($id){
        $sql = "SELECT * FROM dificultadMedia dm
                WHERE dm.preguntaID NOT IN (
                                    SELECT h.idPreg
					                FROM historialUsuario h 
					                WHERE h.idUs = $id)
			    LIMIT 4";

        return $this->database->query($sql);
    }

    private function obtenerPreguntasDificultadDificil($id){
        $sql = "SELECT * FROM dificultadDificil dm
                WHERE dm.preguntaID NOT IN (
                                    SELECT h.idPreg
					                FROM historialUsuario h 
					                WHERE h.idUs = $id)
			    LIMIT 4";

        return $this->database->query($sql);
    }

    private function obtenerPreguntasDificultadFacil($id){
        $sql = "SELECT * FROM dificultadFacil dm
                WHERE dm.preguntaID NOT IN (
                                    SELECT h.idPreg
					                FROM historialUsuario h 
					                WHERE h.idUs = $id)
				LIMIT 4";
        return $this->database->query($sql);
    }

    public function limpiarHistorialUsuario($username){
        $usuario = $this->usuarioModel->getUsuarioByUsername($username)[0];
        $id = $usuario['id'];
        $sql = "DELETE FROM historialUsuario WHERE idUs = '$id'";
        return $this->database->execute($sql);
    }


    public function guardarHistorialUsuario($username,$idPregunta){
        $usuario = $this->usuarioModel->getUsuarioByUsername($username)[0];
        $idUsuario = $usuario['id'];
        $sql = "INSERT INTO historialUsuario (idUs, idPreg) VALUES ($idUsuario,$idPregunta)";
        return $this->database->execute($sql);
    }

    public function guardarHistorialPartida($estadoPregunta,$username,$idPregunta){
        $usuario = $this->usuarioModel->getUsuarioByUsername($username)[0];
        $idUsuario = $usuario['id'];
        $sql = "INSERT INTO historialpartidas (estado,idUs, idPreg) VALUES ($estadoPregunta,$idUsuario,$idPregunta)";
        return $this->database->execute($sql);
    }

    public function actualizarPreguntaTotal($idPregunta){
        $sql = "UPDATE pregunta SET pregTot = pregTot + 1 WHERE id = $idPregunta";
        return $this->database->execute($sql);
    }
}