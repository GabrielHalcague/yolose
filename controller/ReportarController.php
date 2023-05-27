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
        $data["pregunta"] = $this->reportarModel->getPregunta();
        $data["respuestas"] = $this->reportarModel->getRespuestasDePregunta($data["pregunta"][0]["id"]);
        $data['logged'] = Session::get('logged');
        $this->renderer->render("reportar", $data);
    }

}