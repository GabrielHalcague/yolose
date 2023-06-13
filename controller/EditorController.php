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
            $data['usuarioPregu'] = $this->editorModel->obtenerCreadorDePRegunta($idPreg);
            $data['categoria'] = $this->editorModel->obtenerCategorias();
            $data['cateActual'] = $this->editorModel->obtenerCategoriaActual($idPreg);
            $data['estActual'] = $this->editorModel->obtenerEstadoActual($idPreg);
            $data['estado'] = $this->editorModel->obtenerEstados();
            $data['pregunta'] = $pregunta;
            $data['respuestas'] = $this->editorModel->obtenerRespuestasDePregunta($idPreg);
            $data['idRespCorrecta'] = $this->editorModel->obtenerIdRespuestaCorrecta($idPreg);
            var_dump($data['idRespCorrecta']);
            Session::set('datosActualizar', $data);
            $this->render->render("verPregunta", $data);
        }
        
        public function actualizarPregunta()
        {
            echo "llegaste hasta editor";
            echo "<br>";
            $datosPregunta = $this->obtenerDatosPregunta();
            $datosRespuesta = $this->obtenerDatosRespuesta();
            $this->editorModel->actualizarPregunta($datosPregunta);
            $this->editorModel->actualizarRespuesta($datosRespuesta);
            
        }
        
        private function obtenerDatosPregunta()
        {
            $preguActualizada['id'] = Session::get('datosActualizar')['pregunta']['id'];
            $preguActualizada['preg'] = $_POST['pregunta'];
            $preguActualizada['idCat'] = $this->obtenerIdCategoria();
            $preguActualizada['idEst'] = $this->obtenerEstado();
            
            return $preguActualizada;
        }
        
        private function obtenerEstado()
        {
            if (!empty($_POST['estado'])) {
                return $_POST['estado'];
            } else {
                return Session::get('datosActualizar')['estActual']['id'];
            }
        }
        
        private function obtenerIdCategoria()
        {
            if (!empty($_POST['categoria'])) {
                return $_POST['categoria'];
            } else {
                return Session::get('datosActualizar')['cateActual']['id'];
            }
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