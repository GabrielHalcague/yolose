<?php

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
            $data["perfil"]= $this->perfilModel->getPrimerPerfilUsuario();
            $this->renderer->render('perfil', $data);
            exit();
        }
        $username= Session::get('username');
        $data["perfil"]= $this->perfilModel->getPerfilUsuarioPorNombreUsuario($username);
        $this->renderer->render("perfil", $data);
        exit();
    }
    public function usuario(){
        //localhost/perfil/usuario/usuario=11
        $username = $_GET['usuario'] ?? '';
        $data["perfil"]= $this->perfilModel->getPerfilUsuarioPorNombreUsuario($username);
        var_dump( $data["perfil"]);
       $this->renderer->render("perfil", $data);
        exit();
    }
}