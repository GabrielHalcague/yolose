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
        $data = $this->datosComunesParaElPerfil($idUsuario, $data);
        $data["PvPpendientes"] = $this->perfilModel->obtenerHistorialPvPPendientesDelUsuario($idUsuario);
        $data['editarPerfil'] = true;
        $data['perfilJS'] = true;
        $data['mapa'] = true;
        $this->renderer->render("perfil", $data);
        exit();

    }
    public function usuario(){
        $username = $_GET['usuarioBuscado'];
        if($username == Session::get('username')){
            Header::redirect("/");
        }
        $data ["perfil"] = $this->userModel->getUsuarioByUsername($username);
        if(empty($data ["perfil"] )){
            Header::redirect("/");
        }
        $idUsuario=$data["perfil"]["id"];
        $data['editarPerfil'] = false;
        $data['perfilJS'] = true;
        $data['mapa'] = true;
        $data = $this->datosComunesParaElPerfil($idUsuario, $data);
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


    public function obtenerCoordenadas(): void
    {
        $username = $_POST['username'];
        Logger::error("USERNAME OBTENIDO: " . $username);
        $coord = $this->perfilModel->obtenerCoordenadas($username);
        $array = explode(",",$coord);
        $data=[
            'lat' => $array[0],
            'lng' => $array[1]
        ];
        echo json_encode($data);
    }

    public function editar()
    {
        if (!Session::isLogged()) {
            Header::redirect('/');
        }
        $nickName = $_POST["nickName"] ?? null;
        if($this->validarFormatoNick($nickName)){
            $data['nicknameEstado'] = $this->userModel->getUsername($nickName);
        }else{
            $data['nicknameEstado'] = $nickName;
        }
        echo json_encode($data);
    }
    public function confirmar(){
        if (!Session::isLogged()) {
            Header::redirect('/');
        }
        $nickName = $_POST["nickName"] ?? null;
        $idUsuario = $_POST["idUsuario"] ?? null;
        if ($idUsuario != Session::get('idUsuario')) {
            Header::redirect('/');
        }

        if($this->validarFormatoNick($nickName)){
            $this->userModel->setNuevoUsername($idUsuario, $nickName);
            Session::deleteValue('username');
            Session::set('username', $nickName);
            $data['nicknameEstado'] = $nickName;
        }else{
            $data['nicknameEstado'] = null;
        }
        echo json_encode($data);
    }

  private function validarFormatoNick($nickName){
        if(strlen($nickName)<3 ||strlen($nickName)>30 || $nickName == null){
            return false;
        }
        return true;
  }

    public function datosComunesParaElPerfil(mixed $idUsuario, array $data): array
    {
        $data["maximoRespuestasCorrectas"] = $this->perfilModel->getMAximoRespuestasCorrectasPorIdUsuario($idUsuario);
        $data["rank"] = $this->perfilModel->getRankingGlobalDelUsuario($data["perfil"]["id"]);
        $data["historialPartidas"] = $this->perfilModel->obtenerHistorialPartidasUsuario($idUsuario);
        $data["historialPvP"] = $this->perfilModel->obtenerHistorialPvPDelUsuario($idUsuario);
        $data["rutaQR"] = $this->generateQR($data["perfil"]["nombreUsuario"]);
        return $data;
    }

    public function rechazarPartida(){
        if (!Session::isLogged()) {
            Header::redirect('/');
        }
        $token = $_GET['token'];
        $idUsuario= Session::get('idUsuario');
        $this->perfilModel->rechazarPartidaPorToken($token,$idUsuario);

        Header::redirect("/perfil");
    }
}