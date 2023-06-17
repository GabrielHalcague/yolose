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
        if(empty($user) || $user['activo']==1) {
            Header::redirect("/");
        }

        $momentoEnvio = strtotime( $user['f_registro']);
        $momentoActual = (new DateTime)->getTimestamp();

        $dif = (int)(($momentoActual - $momentoEnvio)/6000)/6000;
        Logger::error("LA DIFERENCIA ENTRE LA FECHA DE REGISTRO Y LA FECHA ACTUAL ES: $dif");
        if($dif > 23){
            $data['id']=$id;
            $data['error']="el enlace de activación caduco";
            $this->renderer->render("activacion",$data);
            exit();
        }
        if(!empty($user) && $user['activo'] == 0){
            $this->registerModel->activarUsuario($id);
            $this->registerModel->setRol($id);
            $data["ok"]="Se ha validado correctamente";
        }else
            $data["error"]="No existe el usuario a validar";
        $this->renderer->render('home',$data); //aca debemos ir a home
    }



}