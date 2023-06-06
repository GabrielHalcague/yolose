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
        $data=[];
        /*if (!Session::get('logged')) {
            $data = $this->datosComunesDelHome($data);
            $this->renderer->render("home", $data);
            exit();
        }
            // el rank y el nombre estan en Session. cuadno se gane se tendria que actualizar
            //$data=Session::menuSegunElRol($data);
            $this->renderer->render("home", $data);
        exit();*/
        $data = $this->datosComunesDelHome();
        $this->renderer->render("home", $data);
        exit();
    }

    public function datosComunesDelHome(): array {
        $data["top10"] = $this->homeModel->getTop10();
        //$data["pregunta"] = $this->homeModel->getPregunta();
        //$data["respuestas"] = $this->homeModel->getRespuestasDePregunta($data["pregunta"][0]["id"]);
        return $data;
    }
    private function menuSegunUsuario($rol): array {
        $menu ['menu'][] = array('nombreBoton' => 'home', 'ruta' => '/');
        switch ($rol) {

            case 1:
                $menu ['menu'][] = array('nombreBoton' => 'Solitario', 'ruta' => 'Solitario');
                $menu ['menu'][] = array('nombreBoton' => 'Vs Ia', 'ruta' => 'vsia');
                $menu ['menu'][] = array('nombreBoton' => 'P v P', 'ruta' => 'pvp');
                $menu ['menu'][] = array('nombreBoton' => 'Perfil', 'ruta' => 'perfil');
                return $menu;
            case 2:
                $menu ['menu'][] = array('nombreBoton' => 'editor', 'ruta' => 'editor');
                return $menu;

            case 3:
                $menu ['menu'][] = array('nombreBoton' => 'editor', 'ruta' => 'editor');
                $menu ['menu'][] =array('nombreBoton' => 'admin', 'ruta' => 'admin');
                return $menu;
            default:
                return  $menu;
        }
    }
}