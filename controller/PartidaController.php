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

        if(empty(Session::get('preguntas'))){
            $preguntas = $this->partidaModel->obtenerPreguntas(Session::get('username')); //no tengo stock de preguntas
        }else{
            $preguntas = Session::get('preguntas'); // tengo stock
        }

        if(empty($preguntas)){ // si ya respondio todas las preguntas
            $this->partidaModel->limpiarHistorialUsuario(Session::get('username')); //limpio el historial
            $preguntas = $this->partidaModel->obtenerPreguntas(Session::get('username')); // traer preguntas
        }
        $indicePregunta = array_rand($preguntas);
        $preguntaActual = $preguntas[$indicePregunta];

        $data['js']=true;
        $data['preg'] = [
            'pregunta' => $preguntaActual['pregunta'],
            'color' => $preguntaActual['color']
        ];
        $data['logged'] = Session::get('logged');
        $data['username'] = Session::get('username');
        $data['opc'] = $this->partidaModel->obtenerRespuestaDePregunta($preguntaActual['preguntaID']);

        Session::set('preguntaSeleccionada',$preguntas[$indicePregunta]);
        /*unset($preguntas[$indicePregunta]);*/
        Session::set('preguntas',$preguntas);
        $this->render->render("jugar",$data);
    }

    public function verficar(){
        $id = $_POST['id'];
        $preguntaSeleccionada = Session::get('preguntaSeleccionada');
        //ingresarh historial
        //actualizar pregunta repC

    }

}