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
        $data["pregunta"] = $this->reportarModel->getPregunta()[0];
        //$data["respuestas"] = $this->reportarModel->getRespuestasDePregunta($data["pregunta"]["id"]);
        $data['logged'] = Session::get('logged');
        $this->renderer->render("reportar", $data);
    }

}