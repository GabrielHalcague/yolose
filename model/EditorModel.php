<?php
    
    class EditorModel
    {
        private $database;
        
        public function __construct($database)
        {
            $this->database = $database;
        }
        
        public function obtenerPreguntas()
        {
            $sql = "SELECT distinct p.id,p.preg, p.idCat, p.idEst,p.f_creacion, c.categ, count(r.idPregunta) as 'cantReporte', e.descr
                FROM pregunta p join categoria c on c.id = p.idCat
                    join estado e  on  e.id= p.idEst
              left join   reportepregunta r on p.id = r.idPregunta
              
            group by p.id,p.preg, p.idCat, p.idEst,p.f_creacion, c.categ,e.descr
            order by count(r.idPregunta) DESC  "
        ;
            
            return $this->database->query($sql);
        }
        
        public function obtenerPreguntaPorId($idPreg)
        {
            $sql = "SELECT p.preg FROM pregunta P WHERE P.id= '$idPreg'";
            return $this->database->query_row($sql);
            
            
        }
        
        public function obtenerRespuestasDePregunta($idPreg)
        {
            $sql = "SELECT * FROM respuesta r WHERE r.idPreg= '$idPreg'";
            return $this->database->query($sql);
        }
        
        public function obtenerIdRespuestaCorrecta($idPreg)
        {
            $sql = "SELECT prc.idResp FROM  pregunta_respuesta_correcta prc WHERE prc.idResp='$idPreg'";
            return $this->database->query_row($sql);
        }
        
        
    }