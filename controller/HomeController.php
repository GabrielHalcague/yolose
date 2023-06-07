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
        $data[]=[];
        if (!Session::get('logged')) {
            //$data = $this->datosComunesDelHome($data);
            $this->renderer->render("home", $data);
            exit();
        }
            $this->renderer->render("home", $data);
        exit();
    }

    public function datosComunesDelHome(array $data): array {
        $data["top10"] = $this->homeModel->getTop10();
        $data["pregunta"] = $this->homeModel->getPregunta();
        $data["respuestas"] = $this->homeModel->getRespuestasDePregunta($data["pregunta"][0]["id"]);
        return $data;
    }

}