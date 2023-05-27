<?php
require_once 'helpers/Session.php';
require_once 'helpers/Header.php';
class ValidationController{

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
        $this->renderer->render("validate",$data);
    }

    public function validar(){
        $id = $_GET['id'];
        $user = $this->registerModel->getUserByID($id);
        $momentoEnvio = Session::get('momentoEnvio');
        $momentoActual = (new DateTime)->getTimestamp();
        $dif = (int)(($momentoActual - $momentoEnvio)/60);
        if($dif > 5){
            $data['id']=$id;
            $data['error']="el enlace de activación caduco";
            $data['logged'] = Session::get('logged');
            $this->renderer->render("validate",$data);
            exit();
        }
        if(!empty($user) && $user[0]['activo'] == 0){
            $this->registerModel->activarUsuario($id);
            $data["ok"]="Se ha validado correctamente";
        }else
            $data["error"]="No existe el usuario a validar";
        $this->renderer->render('validate',$data); //aca debemos ir a home
    }



}