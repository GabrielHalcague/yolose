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
      //  if (!Session::get("logged")) {
      //      Header::redirect("/");
      //      exit();
     //   }
        $id= $_GET('id');
        var_dump($id);
        $data["pregunta"] = $this->reportarModel->getPregunta($id);
        $data["respuestas"] = $this->reportarModel->getRespuestasDePregunta($id);
        $data["respuestaCorrecta"]=$this->reportarModel->getRespuestaCorrecta($id);
        $this->renderer->render("reportar", $data);
    }

}