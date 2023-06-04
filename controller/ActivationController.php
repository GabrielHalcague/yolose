<?php
require_once 'helpers/Session.php';
require_once 'helpers/Header.php';
class ActivationController{

    private $renderer;
    private $registerModel;
    private $email;

    public function __construct($renderer, $registroModel){
        $this->renderer = $renderer;
        $this->registerModel = $registroModel;
    }

    public function list()
    {
        $data['username'] = Session::get('username');
        $this->renderer->render("activacion",$data);
    }

    public function activarCuenta(){
        $id = $_GET['id'];
        $user= $this->registerModel->getUserByID($id);
        if(empty($user) || $user[0]['activo']==1) {
            Header::redirect("/");
        }

        $momentoEnvio = strtotime( $user[0]['f_registro']);
        $momentoActual = (new DateTime)->getTimestamp();

        $dif = (int)(($momentoActual - $momentoEnvio)/60)/60;

        if($dif > 23){
            $data['id']=$id;
            $data['error']="el enlace de activación caduco";
           // $data['logged'] = Session::get('logged');
            $this->renderer->render("activacion",$data);
            exit();
        }
        if(!empty($user) && $user[0]['activo'] == 0){
            $this->registerModel->activarUsuario($id);
            $data["ok"]="Se ha validado correctamente";
            Session::set('logged', true);
            Session::set('rol', $user[0]["generoId"]); // cambiar a rol, no esta en la BD
            Session::set('username', $user[0]['nombreUsuario']);

        }else
            $data["error"]="No existe el usuario a validar";
        $this->renderer->render('activacion',$data); //aca debemos ir a home
    }



}