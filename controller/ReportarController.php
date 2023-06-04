<?php

class reportarController
{

    private $renderer;
    private $reportarModel;
    public function __construct($renderer, $reportarModel) {
        $this->renderer = $renderer;
        $this->reportarModel = $reportarModel;

    }
    public function list()
        {
            Header::redirect("/");
            exit();

    }
    public function reportarPregunta(){
        // http://localhost/reportar/reportarPregunta/idReport=3

      if (!Session::get("logged")) {
           Header::redirect("/");
         exit();
         }

        $IdPregunta= $_GET['idReport'] ?? '1';
        $data["pregunta"] = $this->reportarModel->getPregunta($IdPregunta);

        if(empty($data["pregunta"]) == 1){
            // tendria que ir un error de pregunta no encontrada,
            Header::redirect("/");
            exit();
        }

        $data["respuestas"] = $this->reportarModel->getRespuestasDePregunta($IdPregunta);
        $data["respuestaCorrecta"]=$this->reportarModel->getRespuestaCorrectaDePregunta($IdPregunta);

        $data=Session::menuSegunElRol($data);
        $this->renderer->render("reportar", $data);
    }
    public function enviarReporte(){
        Header::redirect("/");
        exit();
    }

}