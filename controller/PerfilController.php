<?php

use JetBrains\PhpStorm\NoReturn;

class PerfilController
{
    private $renderer ;
    private $userModel;

    public function __construct($renderer, $userModel) {
        $this->userModel = $userModel;
        $this->renderer = $renderer;
    }
    public function list(){
        if (!Session::get('logged')) {
            Header::redirect("/");
        }
<<<<<<< Updated upstream
        $rol= Session::get('rol');// para el menu
        $data = $this->menuSegunUsuario($rol);
        $usernmae = Session::get('username');
        $data["perfil"]= $this->userModel->getUsuarioByUsername($usernmae)[0];
        $data['logged'] = Session::get('logged');
=======
        $nombreUsuario = Session::get('username');
        $data["perfil"]= $this->userModel->getPerfilUsuarioPorNombreUsuario($nombreUsuario)[0];

        $data = Session::menuSegunElRol($data);

        $data["rutaQR"]=$this->generateQR($data["perfil"]["nombreUsuario"]);
        $data['showQR'] = true;
>>>>>>> Stashed changes
        $this->renderer->render("perfil", $data);
        exit();
    }

      public function usuario(){
<<<<<<< Updated upstream
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
=======
        //  http://localhost/perfil/usuario/user=gab

        $username = $_GET['user'];
        $usuarioObtenido = $this->userModel->getPerfilUsuarioPorNombreUsuario($username);
        if(empty($usuarioObtenido) == 1){
        //    Session::set('logged',true);
            Header::redirect("/");
        }
            $data["perfil"]= $usuarioObtenido[0];
          $data = Session::menuSegunElRol($data);

          $data["rutaQR"]=$this->generateQR($data["perfil"]["nombreUsuario"]);
          $data['showQR'] = true;
          $this->renderer->render("perfil", $data);
        exit();
     }

    private function generateQR($username){
        $enlace = "http:/localhost/perfil/usuario/user={$username}";
        $ruta = $this->qrGenerator->getQrPng($enlace);
        if(!$ruta){
            exit();
        }
        var_dump($ruta);
        return $ruta;
    }

>>>>>>> Stashed changes
}
