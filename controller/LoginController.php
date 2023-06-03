<?php
require_once 'helpers/Session.php';
require_once 'model/UserModel.php';

class LoginController
{
    private $rendered;
    private $userModel;

    public function __construct($render, $userModel)
    {
        $this->rendered = $render;
        $this->userModel = $userModel;
    }

    public function list()
    {
        if (Session::get('logged')) {
            Header::redirect("/");
        }
        $this->rendered->render('login');
    }

    public function cerrarSesion()
    {
        Session::finalizarSesion();
        Header::redirect("/");
    }

    public function iniciarSesion()
    {
        $usuarioBuscado = [];
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $data['error'] = false;

        $username == '' || $password == '' ? $data['error'] = true: $data['error'] = false;

        if ($data['error']) {
            $data['message'] = "El usuario y/o password no coinciden";
            $this->rendered->render('login', $data);
            exit();
        }

        $usuarioBuscado = $this->userModel->getUsuario($username, $password);
        if(empty($usuarioBuscado)){
            $data['error'] = true;
            $data['message'] = "El usuario no existe";
            $this->rendered->render('login', $data);
            exit();
        }

        if ($usuarioBuscado[0]['activo'] == 1) {
            $roll =$usuarioBuscado[0]["generoId"];// cambiar a rol, no esta en la BD------------
            Session::set('logged', true);
            Session::set('rol', $roll);
            Session::set('nombre', $usuarioBuscado[0]['nombre']);
            Session::set('trampas', $usuarioBuscado[0]['trampas']);
            Session::set('username', $username);
            if($roll==2){
                Session::set('editor', true);
            }
            if($roll==1){
                Session::set('administrador', true);
            }
            header("location:index.php");

            exit();
        }else{
            header("location:validate.php");// no existe
            exit();
        }
     
    }

}