<?php
require_once 'helpers/Session.php';
require_once 'model/UserModel.php';

class LoginController
{

    private $rendered;
    private $userModel;


    public function __construct($render, $userModel)
    {
        Session::initializeSession();
        $this->rendered = $render;
        $this->userModel = $userModel;
    }

    public function list()
    {
        $this->rendered->render('login');
    }

    public function iniciarSesion()
    {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $errores = 0;
        $data['error']=false;
        if ($username == '') {
            $data['error']=true;
            $data['usernameVacio'] = "El campo username esta vacio";
            $errores++;
        }
        if ($password == '') {
            $data['error']=true;
            $data['passwordVacio'] = "El campo password esta vacio";
            $errores++;
        }
        $usuarioBuscado = $this->userModel->getUsuario($username,$password);

        if($errores == 0 && $usuarioBuscado[0]['activo'] == 1 && $username == $usuarioBuscado[0]['nombreUsuario']){
            var_dump(Session::getDataSession());
            Session::set('logged',true);
            Session::set('rol',1);
            Session::set('username',$username);
            $data['logged']=true;
            $data['rol']=1;
            $data['username']=$username;
            $this->rendered->render('home',$data);
            exit();
        }else{
            $data['error'] = true;
            $data['message'] = "El usuario y/o password no coinciden";
            $this->rendered->render('login',$data);
            exit();
        }
    }


}