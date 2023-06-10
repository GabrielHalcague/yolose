<?php
    
    class EditorController
    {
        private $render;
        private $editorModel;
        
        public function __construct($render,$data)
        {
            $this->render = $render;
            $this->editorModel = $data['editorModel'];
        }
        public function list(){
            if (!Session::get('logged')) {
                Header::redirect("/");
            }
            $data['preguntas']= $this->editorModel->obtenerPreguntas();
           
            $this->render->render("editor", $data);
    
           
        }
        public function  verPregunta(){
            $idPreg=  $_GET['idPregunta'];
            var_dump("estas en ver la pregunta ". $idPreg);
            exit();
            $this->render->render("home");
        }
    }