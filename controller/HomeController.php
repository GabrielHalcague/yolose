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
        $data["top10"] = $this->homeModel->getTop10();
        $data["pregunta"] = $this->homeModel->getPregunta();
        $data["respuestas"] = $this->homeModel->getRespuestasDePregunta($data["pregunta"][0]["id"]);

        session_start();
        // este usuario tiene que ser roll
        if (isset($_SESSION["usuario"])) {
            $this->renderer->render("homeUsuario", $data);
        } else {
            $this->renderer->render("home", $data);
        }
    }

}