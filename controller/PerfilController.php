<?php
require_once "helpers/Session.php";
require_once "helpers/QRGenerator.php";
use JetBrains\PhpStorm\NoReturn;

class PerfilController
{
    private $renderer ;
    private $userModel;
    private $qrGenerator;

    public function __construct($renderer, $userModel, $qrGenerator) {
        $this->userModel = $userModel;
        $this->renderer = $renderer;
        $this->qrGenerator = $qrGenerator;
    }
    public function list(){
        if (Session::getDataSession() == null) {
            Header::redirect("/");
        }
        $rol= Session::get('rol');// para el menu
        $data = $this->menuSegunUsuario($rol);
        $usernmae = Session::get('username');

        $data["perfil"]= $this->userModel->getUsuarioByUsername($usernmae)[0];
        //$data["rutaQR"]=$this->generateQR($data["perfil"]["id"]);
        $data['logged'] = Session::get('logged');
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
        $data["perfil"]= $this->userModel->getUsuarioByUsername($username)[0];
        $data['logged'] = Session::get('logged');
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

    private function generateQR($id){
        $enlace = "http:/localhost:80/perfil/usuario/{$id}";
        $ruta = $this->qrGenerator->getQrPng($enlace);
        if(!$ruta){
            exit();
        }
        return $ruta;
    }
}
