<?php

use JetBrains\PhpStorm\NoReturn;

class PerfilController
{
    private $renderer ;
    private $perfilModel;

    public function __construct($renderer, $perfilModel) {
        $this->perfilModel = $perfilModel;
        $this->renderer = $renderer;
    }
    public function list(){
        if (Session::getDataSession() == null) {
            Header::redirect("/");
        }
        $rol= Session::get('rol');// para el menu
        $data = $this->menuSegunUsuario($rol);

        $username= Session::get('username');
        $data["perfil"]= $this->perfilModel->getPerfilUsuarioPorNombreUsuario($username);
        $this->renderer->render("perfil", $data);
        exit();
    }

      public function usuario(){
        if (Session::getDataSession() == null) {
            $data = $this->menuSegunUsuario(0);
        }
        else{
            $rol= Session::get('rol');
            $data = $this->menuSegunUsuario($rol);
        }

        $username = $_GET['usuario'] ?? '';
        $data["perfil"]= $this->perfilModel->getPerfilUsuarioPorNombreUsuario($username);
        $this->renderer->render("perfil", $data);
        exit();
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