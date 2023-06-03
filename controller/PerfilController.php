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
        if (!Session::get('logged')) {
            Header::redirect("/");
        }

        $nombreUsuario = Session::get('username');
        $data["perfil"]= $this->userModel->getPerfilUsuarioPorNombreUsuario($nombreUsuario)[0];

        $data = Session::menuSegunElRol($data);

        $data["rutaQR"]=$this->generateQR($data["perfil"]["nombreUsuario"]);
        $data['showQR'] = true;


        $data['showQR'] = true;

        $this->renderer->render("perfil", $data);
        exit();
    }

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
        $enlace = "http:/localhost:80/perfil/usuario?user={$username}";
        $ruta = $this->qrGenerator->getQrPng($enlace);

        if(!$ruta){
            exit();
        }
        return $ruta;
    }

}
