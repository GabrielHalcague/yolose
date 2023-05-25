<?php

class ValidationController{

    private $renderer;
    private $registerModel;

    public function __construct($renderer, $registerModel){
        $this->renderer = $renderer;
        $this->registerModel = $registerModel;
    }

    public function validar(){
        $id = $_GET['id'];
        $user = $this->registerModel->getUserByID($id);
        if(!empty($user) && $user[0]['activo'] == 0){
            $this->registerModel->activarUsuario($id);
            $data["ok"]="Se ha validado correctamente";
        }
        $data["error"]="No existe el usuario a validar";
        $this->renderer->render('validate',$data);
    }

}