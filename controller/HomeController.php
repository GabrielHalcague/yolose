<?php

class HomeController

{
    private $renderer;
    private $homeModel;

    public function __construct($renderer, $homeModel) {
        $this->homeModel = $homeModel;
        $this->renderer = $renderer;
    }

    public function list() {
        if (!isset($_SESSION["usuario"])) {
            $data["top10"] = $this->homeModel->getTop10();
            $data["pregunta"] = $this->homeModel->getPregunta();
            $data["respuestas"] = $this->homeModel->getRespuestasDePregunta($data["pregunta"][0]["id"]);
            $this->renderer->render("home", $data);
        }
        // si esta seteado y es usuario va a usuario logeado
        if (isset($_SESSION["usuario"])){
            $data["top10"] = $this->homeModel->getTop10();
            $data["pregunta"] = $this->homeModel->getPregunta();
            $data["respuestas"] = $this->homeModel->getRespuestasDePregunta($data["pregunta"][0]["id"]);
            $this->renderer->render("home", $data);
        }
        /*
        // si esta seteado como Editor va a editor
        if (isset($_SESSION["usuario"]) && $_SESSION["usuario"]['rol'] == 2 ) {
            $this->renderer->render("home", $data);
        }
        // si es administador va a administrador
        if (isset($_SESSION["usuario"]) && $_SESSION["usuario"]['rol'] == 3 ) {
            $this->renderer->render("home", $data);
        }
        */

    }

}