<?php

class PartidaController{

    private $render;
    private $partidaModel;

    public function __construct($render, $partidaModel)
    {
        $this->render = $render;
        $this->partidaModel = $partidaModel;
    }

    public function list(){

        if(!Session::getDataSession()){
            Header::redirect("/");
        }
        $preguntas=[];

        if (empty(Session::get('tokenPartida'))) {
            Session::set('tokenPartida', uniqid());
        }

        if(empty(Session::get('preguntas'))){
            $preguntas = $this->partidaModel->obtenerPreguntas(Session::get('username')); //no tengo stock de preguntas
        }else{
            $preguntas = Session::get('preguntas'); // tengo stoc
        }

        if(empty($preguntas)){ // si ya respondio todas las preguntas
            $this->partidaModel->limpiarHistorialUsuario(Session::get('username')); //limpio el historial
            $preguntas = $this->partidaModel->obtenerPreguntas(Session::get('username')); // traer preguntas
        }
        $indicePregunta = array_rand($preguntas);
        $preguntaActual = $preguntas[$indicePregunta];

        $data =[
            'js'=> true,
            'pregunta' => $preguntaActual['pregunta'],
            'username' => Session::get('username'),
            'opc' => $this->partidaModel->obtenerRespuestaDePregunta($preguntaActual['preguntaID']),
            'score' => $this->partidaModel->obtenerScoreDelUsuario(Session::get('tokenPartida'))['puntos'] ?? 0
        ];

        Session::set('preguntaSeleccionada',$preguntas[$indicePregunta]);
        unset($preguntas[$indicePregunta]);
        Session::set('preguntas',$preguntas);
        $this->render->render("jugar",$data);
    }

    public function finalizarPartida(){
        unset($_SESSION['tokenPartida']);
        unset($_SESSION['preguntas']);
        unset($_SESSION['preguntaSeleccionada']);
        Header::redirect("/");
    }

    public function verificar(){

        $id = $_POST['id'];

        $preguntaSeleccionada = Session::get('preguntaSeleccionada');

        if($id == $preguntaSeleccionada['respuestaCorrecta']){
            $data['respValida'] = $preguntaSeleccionada['respuestaCorrecta'];
            //guarda en historialPartida
            $estadoPregunta = 1;
            $nScore = intval($_SESSION['score']);
            $_SESSION['score'] = $nScore + 1;
            $this->partidaModel->guardarHistorialPartida(Session::get('tokenPartida'),$estadoPregunta,Session::get('username'),$preguntaSeleccionada["preguntaID"]);
            $this->partidaModel->actualizarPreguntaCorrecta($preguntaSeleccionada["preguntaID"]);

        }
        else{
            $data['respValida'] = $preguntaSeleccionada['respuestaCorrecta'];
            $data['respActual'] = $id;
            //guarda en historialPartida
            $estadoPregunta = 0;
            $this->partidaModel->guardarHistorialPartida(Session::get('tokenPartida'),$estadoPregunta,Session::get('username'),$preguntaSeleccionada["preguntaID"]);
        }

        //Guarda en historialUsuario
        $this->partidaModel->guardarHistorialUsuario(Session::get('username'),$preguntaSeleccionada["preguntaID"]);

        //Guarda en tabla pregunta
        $this->partidaModel->actualizarPreguntaTotal($preguntaSeleccionada["preguntaID"]);

        $response = array(
            'success' => true,
            'message' => 'Operación exitosa',
            'data' => $data // Puedes incluir datos adicionales si es necesario
        );

        echo json_encode($response);
    }

}