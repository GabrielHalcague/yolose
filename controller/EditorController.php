<?php
    
    class EditorController
    {
        private $render;
        private $editorModel;
        
        public function __construct($render, $data)
        {
            $this->render = $render;
            $this->editorModel = $data['editorModel'];
        }
        
        public function list()
        {
            if (!Session::get('logged')) {
                Header::redirect("/");
            }
            
            Session::set('listaPreguntas', $this->editorModel->obtenerPreguntas());
            
            $data['preguntas'] = Session::get('listaPreguntas');
            $this->render->render("editor", $data);
            
            
        }
        
        public function verPregunta()
        {
            $idPreg = $_GET['pregunta'];
            $pregunta = $this->editorModel->obtenerPreguntaPorId($idPreg);
            $data['pregunta'] = $pregunta['preg'];
            $data['respuestas'] = $this->editorModel->obtenerRespuestasDePregunta($idPreg);
            $data['idRespCorrecta'] = $this->editorModel->obtenerIdRespuestaCorrecta($idPreg);
            var_dump($data['respuestas']);
            $this->render->render("verPregunta", $data);
        }
    }