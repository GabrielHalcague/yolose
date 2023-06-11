<?php
require_once "helpers/Session.php";
require_once "helpers/QRGenerator.php";
use JetBrains\PhpStorm\NoReturn;

class PerfilController
{
    private $renderer ;
    private $userModel;
    private $perfilModel;
    private $qrGenerator;

    public function __construct($renderer, $userModel, $perfilModel, $qrGenerator) {
        $this->userModel = $userModel;
        $this->perfilModel = $perfilModel;
        $this->renderer = $renderer;
        $this->qrGenerator = $qrGenerator;
    }
    public function list(){
        if (!Session::get('logged')) {
            Header::redirect("/");
        }
        $nombreUsuario = Session::get('username');
        $data["perfil"]= $this->userModel->getUsuarioByUsername($nombreUsuario);
        $idUsuario=$data["perfil"]["id"];
        $data["maximoRespuestasCorrectas"]= $this->perfilModel->getMAximoRespuestasCorrectasPorIdUsuario($idUsuario);
        $data["rank"]= $this->perfilModel->getRankingGlobalDelUsuario($data["perfil"]["id"]);
        $data["historialPartidas"] = $this->perfilModel->obtenerHistorialPartidasUsuario($idUsuario);
        $data["rutaQR"]=$this->generateQR($data["perfil"]["nombreUsuario"]);
        $data['showQR'] = true;
        $this->renderer->render("perfil", $data);
        exit();

    }
    public function usuario(){
        //  http://localhost/perfil/usuario/user=gab
        $username = $_GET['user'];
        $usuarioObtenido = $this->userModel->getUsuarioByUsername($username);
        if(empty($usuarioObtenido) == 1){
            Header::redirect("/");
        }
        $data["perfil"]= $usuarioObtenido;
        $data["mejorPartida"]= "10";
        $data["rank"]= "100";
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

    public function obtenerHistorialPartidas($nombreUsuario)
    {
        $usuario = $this->userModel->getUsuarioByUsername($nombreUsuario);
        return $this->userModel->obtenerHistorialPartidasUsuario($usuario["id"]);
    }

}