<?php
    
    
    class HomeController
    {
        private $renderer;
        private $homeModel;
        
        public function __construct($renderer, $homeModel)
        {
            $this->homeModel = $homeModel;
            $this->renderer = $renderer;
        }
        
        public function list()
        {
            $data["top10"] = $this->homeModel->getTop10();
            $this->renderer->render("home", $data);
            exit();
        }
        
        public function datosComunesDelHome(array $data): array
        {
            $data["top10"] = $this->homeModel->getTop10();
            $data["pregunta"] = $this->homeModel->getPregunta();
            $data["respuestas"] = $this->homeModel->getRespuestasDePregunta($data["pregunta"][0]["id"]);
            return $data;
        }
        
    }