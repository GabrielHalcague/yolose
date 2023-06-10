<?php
    
    class EditorModel
    {
        private $database;
        public function __construct($database)
        {
            $this->database= $database;
        }
        public function obtenerPreguntas(){
            $sql= "SELECT p.id,p.preg FROM pregunta p   ";
            return $this->database->query($sql);
        }
    }