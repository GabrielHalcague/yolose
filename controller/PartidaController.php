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
            $preguntas = $this->partidaModel->obtenerPreguntas(Session::get('username'));
        }else{
            $preguntas = Session::get('preguntas');
        }
        if(empty($preguntas)){
            $this->partidaModel->limpiarHistorialUsuario(Session::get('username'));
            $preguntas = $this->partidaModel->obtenerPreguntas(Session::get('username'));
        }
        $indicePregunta = array_rand($preguntas);
        $preguntaActual = $preguntas[$indicePregunta];

        $data['js']=true;
        $data['preg'] = $preguntaActual;
        $data['logged'] = Session::get('logged');
        $data['username'] = Session::get('username');
        $data['opc'] = $this->partidaModel->obtenerRespuestaDePregunta($preguntaActual['id']);


        Session::set('preguntaSeleccionada',$preguntas[$indicePregunta]);
        /*unset($preguntas[$indicePregunta]);*/
        Session::set('preguntas',$preguntas);
        /*Header::debugExit($data);*/
        $this->render->render("jugar",$data);
    }

    public function verficar($id){
        $preguntaSeleccionada = Session::get('preguntaSeleccionada');

    }

}