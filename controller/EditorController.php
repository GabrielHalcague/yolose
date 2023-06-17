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
            if (!Session::get('logged') || Session::get('rol') == 'Usuario') Header::redirect("/");
            Session::set('listaPreguntas', $this->editorModel->obtenerPreguntas());
            $data['preguntas'] = Session::get('listaPreguntas');
            $this->render->render("editor", $data);
        }
        
        public function verPregunta()
        {
            Session::deleteValue('datosActualizar');
           
            $idPreg = $_GET['pregunta'];
            $data['idPreg']= $idPreg;
            $data['pregunta']=$this->editorModel->obtenerDatosDePregunta($idPreg);
            $data['estado'] = $this->editorModel->obtenerEstados();
            $data['respuestas'] = $this->editorModel->obtenerRespuestasDePregunta($idPreg);
            $data['categoria'] = $this->editorModel->obtenerCategorias();
            $data['idRespCorrecta'] = $this->editorModel->obtenerIdRespuestaCorrecta($idPreg);
            Session::set('datosActualizar', $data);
            $this->render->render("verPregunta", $data);
        }
        
        public function actualizarPregunta()
        {
            $datosPregunta = $this->obtenerDatosPregunta();
           $datosRespuesta = $this->obtenerDatosRespuesta();
            $this->editorModel->actualizarPregunta($datosPregunta);
            $this->editorModel->actualizarRespuesta($datosRespuesta);
           Header::redirect('/editor');
        }
        
        public function verQuienReporto(){
            $idPreg= $_GET['pregunta'];
            $data['pregunta'] = $this->editorModel->obtenerPreguntaPorId($idPreg);
            $data['reporte']= $this->editorModel->obtenerInformacionDeReporte($idPreg);
            $this->render->render("verReporte",$data);
        }
        
        private function obtenerDatosPregunta()
        {
            $preguActualizada['id'] = Session::get('datosActualizar')['pregunta']['idPreg'];
            $preguActualizada['preg'] = $_POST['pregunta'];
            $preguActualizada['idCat'] = $this->obtenerIdCategoria();
            $preguActualizada['idEst'] = $this->obtenerEstado();
            return $preguActualizada;
        }
        
        private function obtenerEstado()
        {
            if (!empty($_POST['estado'])) return $_POST['estado'];
            else return Session::get('datosActualizar')['pregunta']['idEst'];
        }
        
        private function obtenerIdCategoria()
        {
            if (!empty($_POST['categoria'])) return $_POST['categoria'];
            else return Session::get('datosActualizar')['pregunta']['idCat'];
        }
        private function obtenerDatosRespuesta()
        {
            $datosActualizar = Session::get('datosActualizar')['respuestas'];
            $nuevaRespuesta = [];
            foreach ($datosActualizar as $dato) {
                $resp['id'] = $dato['id'];
                $resp['resp'] = $_POST["respuesta" . $dato['id']];
                $nuevaRespuesta[$dato['id']] = $resp;
            }
            return $nuevaRespuesta;
        }
    }