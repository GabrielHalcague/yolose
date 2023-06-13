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
            Session::deleteValue('datosActualizar');
            $idPreg = $_GET['pregunta'];
            $pregunta = $this->editorModel->obtenerPreguntaPorId($idPreg);
            $data['usuarioPregu']= $this->editorModel->obtenerCreadorDePRegunta($idPreg);
            $data['categoria'] = $this->editorModel->obtenerCategorias();
            $data['cateActual']= $this->editorModel->obtenerCategoriaActual($idPreg);
            $data['estActual']= $this->editorModel->obtenerEstadoActual($idPreg);
            $data['estado']= $this->editorModel->obtenerEstados();
            $data['pregunta'] = $pregunta['preg'];
            $data['respuestas'] = $this->editorModel->obtenerRespuestasDePregunta($idPreg);
            $data['idRespCorrecta'] = $this->editorModel->obtenerIdRespuestaCorrecta($idPreg);
            var_dump($data['idRespCorrecta']);
            Session::set('datosActualizar',$data);
            $this->render->render("verPregunta", $data);
        }
        public function actualizarPregunta(){
            echo "llegaste hasta editor";
            $datos= $this->obtenerDatos();
            
            var_dump($_POST);
            exit();
        }
    
        private function obtenerDatos()
        {
            if(empty($_POST['pregunta'])){
            
            }
        }
    }