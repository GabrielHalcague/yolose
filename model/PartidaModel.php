<?php
require_once 'model/UserModel.php';
require_once 'model/PreguntaModel.php';
require_once 'model/OpcionModel.php';
require_once 'helpers/Logger.php';

class PartidaModel
{

    private mixed $database;
    private mixed $usuarioModel;
    private mixed $preguntaModel;
    private mixed $opcionModel;

    public function __construct($database, $models)
    {
        $this->database = $database;
        $this->preguntaModel = $models['pregunta'];
        $this->opcionModel = $models['opcion'];
        $this->usuarioModel = $models['usuario'];
    }

    public function obtenerPreguntasParaUsuario($username): array
    {
        $usuario = $this->usuarioModel->getUsuarioByUsername($username)[0];
        $dificultadUsuario = $this->obtenerDificultadUsuario($usuario['id']);
        $arrayPreguntas = [];
        if (empty($dificultadUsuario)) {
            $arrayPreguntas = $this->preguntaModel->obtenerPreguntasDificultadMedia();
        } else {
            $dif = $dificultadUsuario[0]['dificultad'];
            do {
                if ($dif >= 0 && $dif <= 0.3) {
                    $arrayPreguntas = $this->obtenerPreguntasDificultadDificil($usuario['id']);
                    if (empty($arrayPreguntas)) { // si ya respondio todas las preguntas
                        $this->limpiarHistorialUsuario($usuario['id']); //limpio el historial
                    }
                }
                if ($dif > 0.3 && $dif <= 0.7) {
                    $arrayPreguntas = $this->obtenerPreguntasDificultadMedia($usuario['id']);
                    if (empty($arrayPreguntas)) { // si ya respondio todas las preguntas
                        $this->limpiarHistorialUsuario($usuario['id']); //limpio el historial
                    }
                }
                if ($dif > 0.7 && $dif <= 1) {
                    $arrayPreguntas = $this->obtenerPreguntasDificultadFacil($usuario['id']);
                    if (empty($arrayPreguntas)) { // si ya respondio todas las preguntas
                        $this->limpiarHistorialUsuario($usuario['id']); //limpio el historial
                    }
                }
            }while(empty($arrayPreguntas));

        }
        return $arrayPreguntas;
    }

    public function validarRespuesta($data): array
    {
        $id = $data['seleccionUsuario'];
        $preguntaSeleccionada = $data['preguntaActual'];
        $muestroPregunta = $data['muestroPregunta'];
        $respondioPregunta = $data['respondioPregunta'];
        $array = [
            'correcto' => false,
            'fueraTiempo' => false,
        ];
        $dif = (int)(($respondioPregunta - $muestroPregunta) / 60) / 60;
        if ($dif <= 10) {
            Logger::info("CONTESTO LA PREGUNTA EN EL TIEMPO LIMITE DE LOS 10 SEG");
            $array['respActual'] = $id;
            if ($id == $preguntaSeleccionada['respuestaCorrecta']) {
                $array['correcto'] = true;
            } else {
                $array['respValida'] = $preguntaSeleccionada['respuestaCorrecta'];
            }
        } else {
            Logger::info("NO CONTESTO LA PREGUNTA EN EL TIEMPO LIMITE DE LOS 10 SEG");
            $array['fueraTiempo'] = true;
            $array['respValida'] = $preguntaSeleccionada['respuestaCorrecta'];
        }


        $this->actualizaPregunta($preguntaSeleccionada['preguntaID'], $data['correcto']);

        $this->agregarHistorialUsuario([
            'username' => $data['username'],
            'idPreg' => $preguntaSeleccionada['preguntaID'],
        ]);

        $this->agregarHistorialPartida([
            'n_partida' => $data['tokenPartida'],
            'estado' => $data['correcto'],
            'username' => $data['username'],
            'idPreg' => $preguntaSeleccionada['preguntaID']
        ]);
        return $array;
    }

    private
    function obtenerDificultadUsuario($id)
    {
        $sql = "SELECT * FROM dificultadUsuario WHERE idUs = $id";
        return $this->database->query($sql);
    }

    public
    function obtenerRespuestaDePregunta($id)
    {
        return $this->opcionModel->obtenerOpcionesDePregunta($id);
    }

    private
    function obtenerPreguntasDificultadMedia($id)
    {
        $sql = "SELECT * FROM dificultadMedia dm
                WHERE dm.preguntaID NOT IN (
                                    SELECT h.idPreg
					                FROM historialUsuario h 
					                WHERE h.idUs = $id)
			    LIMIT 4";

        return $this->database->query($sql);
    }

    private
    function obtenerPreguntasDificultadDificil($id)
    {
        $sql = "SELECT * FROM dificultadDificil dm
                WHERE dm.preguntaID NOT IN (
                                    SELECT h.idPreg
					                FROM historialUsuario h 
					                WHERE h.idUs = $id)
			    LIMIT 4";

        return $this->database->query($sql);
    }

    private
    function obtenerPreguntasDificultadFacil($id)
    {
        $sql = "SELECT * FROM dificultadFacil dm
                WHERE dm.preguntaID NOT IN (
                                    SELECT h.idPreg
					                FROM historialUsuario h 
					                WHERE h.idUs = $id)
				LIMIT 4";
        return $this->database->query($sql);
    }

    public
    function limpiarHistorialUsuario($userID)
    {
        $sql = "DELETE FROM historialUsuario WHERE idUs = '$userID'";
        return $this->database->execute($sql);
    }

    public function obtenerScoreDelUsuario($tokenPartida)
    {
        $sql = "SELECT u.id, SUM(hp.estado=1) 'puntos'
                FROM historialPartidas hp JOIN usuario u on u.id = hp.idUs
                WHERE hp.n_partida LIKE '$tokenPartida'
                GROUP BY u.id";
        return $this->database->query($sql);
    }

    public function obtenerScoresDeUnVsPlayer($tokenPartida)
    {
        $sql = "SELECT u.nombreUsuario, SUM(hp.estado=1) 'punt'
                FROM historialPartidas hp JOIN usuario u on u.id = hp.idUs
                WHERE hp.n_partida LIKE '$tokenPartida'
                GROUP BY u.nombreUsuario";
        return $this->database->query($sql);
    }

    private function actualizaPregunta($pregunta, $estado): void
    {
        if ($estado) {
            $sql = "UPDATE pregunta p 
                    SET p.resCor = p.resCor + 1,
                        p.pregTot = p.pregTot + 1
                    WHERE p.id = $pregunta";
        } else {
            $sql = "UPDATE pregunta p 
                    SET p.pregTot = p.pregTot + 1
                    WHERE p.id = $pregunta";
        }
        $this->database->execute($sql);
    }

    public function agregarHistorialUsuario($data): void
    {
        $idUsuario = $this->usuarioModel->getUsuarioByUsername($data['username'])[0]['id'];
        $idPreg = $data['idPreg'];
        $sql = "INSERT INTO historialUsuario (idUs, idPreg) VALUES ('$idUsuario','$idPreg')";
        $this->database->execute($sql);
    }

    public function agregarHistorialPartida($data): void
    {
        $idUsuario = $this->usuarioModel->getUsuarioByUsername($data['username'])[0]['id'];
        $idPreg = $data['idPreg'];
        $token = $data['n_partida'];
        $estado = $data['estado'];
        $sql = "INSERT INTO historialPartidas (estado, idUs, idPreg, n_partida) VALUES ('$estado','$idUsuario','$idPreg','$token')";
        $this->database->execute($sql);
    }

}