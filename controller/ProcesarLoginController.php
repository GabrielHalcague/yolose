<?php

class ProcesarLoginController
{
    private $render;
    private $UserModel;
    function __construct($render , $UserModel){
        $this->render =$render;
        $this->UserModel = $UserModel;
    }
    public function list(){
        session_start();
        $usuario= $this->UserModel->getUsuarioByEmail($_POST['email'] , $_POST['password']);

       if(!empty($usuario)){
           $data["usuario"] = $usuario;
           $_SESSION["usuario"] = $usuario;
           $this->render->render("home", $data);

        }else{
              $this->render->render("home");
        }
    }

}