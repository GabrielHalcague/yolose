<?php
require_once 'Services/PreguntaServices.php';
require_once 'helpers/Logger.php';

class PartidaModel
{
    private mixed $database;
    private mixed $preguntaServices;


    public function __construct($database, $preguntaServices)
    {
        $this->database = $database;
        $this->preguntaServices = $preguntaServices;
    }

    public function obtenerPreguntasParaUsuario($id): array
    {
        $dificultadUsuario = $this->obtenerDificultadUsuario($id);
        $arrayPreguntas = [];
        if (empty($dificultadUsuario)) {
            $arrayPreguntas = $this->preguntaServices->obtenerPreguntasDificultadMedia();
        } else {
            $dif = $dificultadUsuario['dificultad'];
            do {
                if ($dif >= 0 && $dif <= 0.3) {
                    $arrayPreguntas = $this->obtenerPreguntasDificultadDificil($id);
                    if (empty($arrayPreguntas)) { // si ya respondio todas las preguntas
                        $this->limpiarHistorialUsuario($id); //limpio el historial
                    }
                }
                if ($dif > 0.3 && $dif <= 0.7) {
                    $arrayPreguntas = $this->obtenerPreguntasDificultadMedia($id);
                    if (empty($arrayPreguntas)) { // si ya respondio todas las preguntas
                        $this->limpiarHistorialUsuario($id); //limpio el historial
                    }
                }
                if ($dif > 0.7 && $dif <= 1) {
                    $arrayPreguntas = $this->obtenerPreguntasDificultadFacil($id);
                    if (empty($arrayPreguntas)) { // si ya respondio todas las preguntas
                        $this->limpiarHistorialUsuario($id); //limpio el historial
                    }
                }
            } while (empty($arrayPreguntas));

        }
        return $arrayPreguntas;
    }

    public function validarRespuesta($data): array
    {
        $id = $data['seleccionUsuario']; // LA OPCIÓN SELECCIONADA POR EL USUARIO
        $preguntaSeleccionada = $data['preguntaActual'];
        $muestroPregunta = $data['muestroPregunta']; //CUANDO SE MOSTRO POR PANTALLA LA PREGUNTA
        $respondioPregunta = $data['respondioPregunta']; //CUANDO SE RESPONDIO
        $array = [
            'correcto' => false,
            'fueraTiempo' => false,
        ];
        $dif = $respondioPregunta - $muestroPregunta;
        Logger::info("LA DIFERENCIA ENTRE LA MUESTRA Y RESPUESTA ES: $dif");
        if ($id != 'FUERA_TIEMPO') {
            if ($dif < 10) {
                Logger::info("[CONTESTO LA PREGUNTA EN EL TIEMPO LIMITE DE LOS 10 SEG]");
                if ($id != 'trampa') {
                    $array['respActual'] = $id;
                    if ($id == $preguntaSeleccionada['respuestaCorrecta']) {
                        Logger::info("[RESPUESTA CORRECTA]");
                        $array['correcto'] = true;
                    } else {
                        Logger::info("[RESPUESTA INCORRECTA]");
                        $array['respValida'] = $preguntaSeleccionada['respuestaCorrecta'];
                    }
                } else {
                    Logger::info("[SE UTILIZO TRAMPA]");
                    $array['correcto'] = true;
                    $array['respValida'] = $preguntaSeleccionada['respuestaCorrecta'];
                }
            } else {
                Logger::info("[NO CONTESTO LA PREGUNTA EN EL TIEMPO LIMITE DE LOS 10 SEG]");
                $array['fueraTiempo'] = true;
                $array['respValida'] = $preguntaSeleccionada['respuestaCorrecta'];
            }
        } else {
            Logger::info("[NO CONTESTO LA PREGUNTA SALIO POR EL TIMEOUT]");
            $array['fueraTiempo'] = true;
            $array['respValida'] = $preguntaSeleccionada['respuestaCorrecta'];
        }


        $this->actualizaPregunta($preguntaSeleccionada['preguntaID'], $array['correcto']);

        $this->agregarHistorialUsuario([
            'idUsuario' => $data['idUsuario'],
            'idPreg' => $preguntaSeleccionada['preguntaID'],
        ]);

        $this->agregarHistorialPartida([
            'n_partida' => $data['tokenPartida'],
            'estado' => $array['correcto'],
            'idUsuario' => $data['idUsuario'],
            'idPreg' => $preguntaSeleccionada['preguntaID'],
            'tipoPartida' => $data['tipoPartida']
            //'estadoPartida' => $data['estadoPartida']
        ]);
        return $array;
    }

    private
    function obtenerDificultadUsuario($id)
    {
        $sql = "SELECT * FROM dificultadUsuario WHERE idUs = $id";
        return $this->database->query_row($sql);
    }

    public
    function obtenerRespuestaDePregunta($id)
    {
        return $this->preguntaServices->obtenerOpcionesDePregunta($id);
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

    public function obtenerScoreDelUsuario($tokenPartida, $username)
    {
        $sql = "SELECT u.id, SUM(hp.estado=1) 'puntos'
                FROM historialPartidas hp JOIN usuario u on u.id = hp.idUs
                WHERE hp.n_partida LIKE '$tokenPartida' AND u.nombreUsuario LIKE '$username'
                GROUP BY u.id";
        return $this->database->query_row($sql);
    }

    public function obtenerScoresDeUnVsPlayer($tokenPartida)
    {
        $sql = "SELECT u.nombreUsuario, SUM(hp.estado=1) 'punt'
                FROM historialPartidas hp JOIN usuario u on u.id = hp.idUs
                WHERE hp.n_partida LIKE '$tokenPartida'
                GROUP BY u.nombreUsuario";
        return $this->database->query($sql);
    }

    public function actualizaPregunta($pregunta, $estado): void
    {
        if ($estado == true) {
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
        $idUsuario = $data['idUsuario'];
        $idPreg = $data['idPreg'];
        $sql = "INSERT INTO historialUsuario (idUs, idPreg) VALUES ('$idUsuario','$idPreg')";
        $this->database->execute($sql);
    }

    public function agregarHistorialPartida($data): void
    {
        $idUsuario = $data['idUsuario'];
        $idPreg = $data['idPreg'];
        $token = $data['n_partida'];
        $estado = $data['estado'];
        $tipoPartida = $data['tipoPartida'];
        $estadoPartida = $data['estadoPartida'];

        if (!$estado) {
            $sql = "INSERT INTO historialPartidas (idUs, idPreg, n_partida,tipoPartida) VALUES ('$idUsuario','$idPreg','$token','$tipoPartida','$estadoPartida')";
        } else {
            $sql = "INSERT INTO historialPartidas (estado, idUs, idPreg, n_partida,tipoPartida) VALUES ('$estado','$idUsuario','$idPreg','$token','$tipoPartida','$estadoPartida')";
        }
        $this->database->execute($sql);
    }

    public function obtenerTrampasDelUsuario($id)
    {
        $sql = "SELECT u.trampas FROM usuario u WHERE u.id = $id";
        return $this->database->query_row($sql);
    }

    public function actualizaTrampasUsuario($cantTrampasTotales, $idUsuario)
    {
        $sql = "UPDATE usuario u SET u.trampas = $cantTrampasTotales WHERE id = $idUsuario";
        $this->database->execute($sql);
    }
    public function reportarPregunta($idPregunta,$idUsuario){
        $sql= "INSERT INTO reportePregunta(idPregunta,idUsuario) values('$idPregunta','$idUsuario')";
       $this->database->execute($sql);
    }
}