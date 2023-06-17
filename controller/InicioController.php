<?php

class InicioController
{
    private $renderer;

    public function __construct($renderer)
    {
        $this->renderer = $renderer;
    }

    public function list()
    {
        if(!empty(Session::get('logged'))){
            Header::redirect("home");
        }else{

            $this->renderer->render("inicio");
            exit();
        }
    }

}