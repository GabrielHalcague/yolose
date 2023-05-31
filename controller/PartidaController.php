<?php

class PartidaController{


    private $render;
    private $preguntaModel;
    private $opcionModel;
    private $categorialModel;
    private $userModel;

    public function __construct($render, $models)
    {
        $this->render = $render;
        $this->preguntaModel = $models['pregunta'];
        $this->opcionModel = $models['opcion'];
        $this->categorialModel = $models['categoria'];
        $this->userModel = $models['usuario'];
    }

    public function list(){
        if(!Session::getDataSession()){
            Header::redirect("/");
        }
        $data['logged'] = Session::get('logged');
        $data['username'] = Session::get('username');
        $preguntas=[];

        if(empty(Session::get('preguntas'))){
            $preguntas = $this->preguntaModel->obtenerTodasLasPreguntas();
        }else{
            $preguntas = Session::get('preguntas');
        }

        $indicePregunta = array_rand($preguntas);
        $preguntaActual = $preguntas[$indicePregunta];

        $data['pregunta'] = $preguntaActual;

        $data['opciones'] = $this->opcionModel->obtenerOpcionesDePregunta($preguntaActual['id']);
        Header::debug($data);
        $this->render->render("jugar",$data);
    }

}