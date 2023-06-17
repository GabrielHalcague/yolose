<?php
    
    class EditorModel
    {
        private $database;
        
        public function __construct($database)
        {
            $this->database = $database;
        }
        
        public function obtenerDatosDePregunta($idPreg){
            $sql= "select p.id as idPreg,p.preg,p.f_creacion,e.id as idEst, e.descr, c.id as idCat, c.categ, u.nombreUsuario
                    from pregunta p
                    join categoria c on c.id = p.idCat
                    join estado e on e.id = p.idEst
                                     join usuario u on u.id= p.idUsuario
                    where p.id= '$idPreg'";
            return $this->database->query_row($sql);
        }
        
        public function obtenerPreguntas()
        {
            $sql = "SELECT distinct p.id,p.preg, p.idCat, p.idEst,p.f_creacion, c.categ, count(r.idPregunta) as 'cantReporte', e.descr
                FROM pregunta p join categoria c on c.id = p.idCat
                    join estado e  on  e.id= p.idEst
              left join reportePregunta r on p.id = r.idPregunta
              
            group by p.id,p.preg, p.idCat, p.idEst,p.f_creacion, c.categ,e.descr
            order by count(r.idPregunta) DESC  ";
            return $this->database->query($sql);
        }
        
        public function obtenerPreguntaPorId($idPreg)
        {
            $sql = "SELECT p.id, p.preg, p.f_creacion FROM pregunta P WHERE P.id= '$idPreg'";
            return $this->database->query_row($sql);
            
        }
        
        public function obtenerRespuestasDePregunta($idPreg)
        {
            $sql = "SELECT * FROM respuesta r WHERE r.idPreg= '$idPreg'";
            return $this->database->query($sql);
        }
        
        public function obtenerIdRespuestaCorrecta($idPreg)
        {
            $sql = "SELECT prc.idResp FROM  pregunta_respuesta_correcta prc WHERE prc.idPreg='$idPreg'";
            return $this->database->SoloValorCampo($sql);
        }
        
        public function obtenerCategorias()
        {
            $sql = "SELECT * FROM  categoria ";
            return $this->database->query($sql);
        }
        
        public function obtenerEstados()
        {
            $sql = "SELECT * FROM  estado ";
            return $this->database->query($sql);
        }
        
        public function actualizarPregunta($datosPregunta)
        {
            $sql = "UPDATE  pregunta p
                    set p.preg= '$datosPregunta[preg]',
                        p.idCat= '$datosPregunta[idCat]',
                        p.idEst= '$datosPregunta[idEst]'
                        where id= '$datosPregunta[id]'  ";
            $this->database->execute($sql);
        }
        
        public function actualizarRespuesta($datosRespuesta)
        {
            foreach ($datosRespuesta as $dato) {
                $sql = "UPDATE  respuesta r
                 set r.resp= '$dato[resp]'
                where r.id= '$dato[id]'  ";
                $this->database->execute($sql);
            }
        }
        public function obtenerInformacionDeReporte($idPreg){
            $sql = "SELECT  p.id,u.nombreUsuario, r.f_reporte FROM  pregunta p join reportepregunta r on p.id= r.idPregunta
                    join usuario u on u.id = r.idUsuario
                where p.id= '$idPreg'";
            return $this->database->query($sql);
    }
        
    }