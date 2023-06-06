<?php
require_once "helpers/Session.php";
require_once "helpers/QRGenerator.php";

use JetBrains\PhpStorm\NoReturn;

class PerfilController
{
    private $renderer;
    private $userModel;
    private $qrGenerator;

    public function __construct($renderer, $userModel, $qrGenerator)
    {
        $this->userModel = $userModel;
        $this->renderer = $renderer;
        $this->qrGenerator = $qrGenerator;
    }

    public function list()
    {
        Header::redirect("/");
    }

    public function usuario()
    {
        if (is_null(Session::getDataSession())) {
            Header::redirect("/");
        }

        if (empty($_GET['user'])) {
            Header::redirect("/");
        }

        $username = $_GET['user'];
        $usuarioObtenido = $this->userModel->getUsuarioByUsername($username);

        if (empty($usuarioObtenido)) {
            Header::redirect("/");
        }

        $data = [
            "perfil" => $usuarioObtenido,
            "rutaQR" => $this->generateQR($usuarioObtenido["nombreUsuario"])
        ];
        $this->renderer->render("perfil", $data);
        exit();
    }

    private function generateQR($username)
    {
        $enlace = "http:/localhost:80/perfil/usuario&user={$username}";
        $ruta = $this->qrGenerator->getQrPng($enlace);

        if (!$ruta) {
            exit();
        }
        return $ruta;
    }
}
