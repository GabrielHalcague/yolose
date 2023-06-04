<?php

class reportarController
{

    private $renderer;
    private $reportarModel;
    public function __construct($renderer, $reportarModel) {
        $this->renderer = $renderer;
        $this->reportarModel = $reportarModel;

    }
    public function list() {
        //Verificar rol

        $rol = Session::get('rol');

        if($rol != 'Editor'){
            Header::redirect('/');
        }

        $data["pregunta"] = $this->reportarModel->obtenerPreguntas();
        $data['logged'] = Session::get('logged');
        $this->renderer->render("reportar", $data);
    }



}