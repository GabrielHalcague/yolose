<?php

class PreguntaController{
    
    private $renderer;
    private $preguntaModel;
    private $respuestaModel;
    private $categoriaModel;

    public function __construct($renderer, $models){
        $this->renderer = $renderer;
        $this->preguntaModel = $models['pregunta'];
        $this->respuestaModel = $models['respuesta'];
        $this->categoriaModel = $models['categoria'];
    }

    public function list(){

        if(empty(Session::getDataSession())){
            Header::redirect("/");
        }
        
        $data['categoria'] = $this->categoriaModel->getAllCategories();
        $this->renderer->render("agregarPregunta",$data);
    }

//    public function agregarPregunta(){
//        $cError = 0;
//        $pregunta = $_POST['preg'] ?? '';
//        if($pregunta == ''){
//            $cError ++;
//            $data['errorPregunta'] = "la pregunta no debe ser vacia";
//        }
//        $categoria = $_POST['cate'] ?? '';
//        if($categoria == ''){
//            $cError ++;
//            $data['errorCategoria'] = "categoria invalida";
//        }
//        $resp1 = $_POST['resp1'] ?? '';
//        if($resp1 == ''){
//            $cError ++;
//            $data['errorResp1'] = "La respuesta 1 no puede ser vacio";
//        }
//        $resp2 = $_POST['resp2'] ?? '';
//        if($resp1 == ''){
//            $cError ++;
//            $data['errorResp2'] = "La respuesta 2 no puede ser vacio";
//        }
//        $resp3 = $_POST['resp3'] ?? '';
//        if($resp1 == ''){
//            $cError ++;
//            $data['errorResp3'] = "La respuesta 3 no puede ser vacio";
//        }
//        $resp4 = $_POST['resp4'] ?? '';
//        if($resp1 == ''){
//            $cError ++;
//            $data['errorResp4'] = "La respuesta 4 no puede ser vacio";
//        }
//
//        if($cError == 0){
//            $this->preguntaModel->agregarPregunta([$pregunta,$categoria]);
//            $id = $this->preguntaModel->obtenerIdPregunta($pregunta);
//            $this->respuestaModel->agregarRespuestas([$resp1,$resp2,$resp3,$resp4],$id);
//            Header::redirect("/");
//        }else{
//            $this->renderer->render("ingreso",$data);
//        }
//    }
    
    public function agregarPregunta()
    {
        $datosDePregunta = $this->obtenerDatosDePregunta();
        $idUsuario = Session::get('idUsuario');
        $this->preguntaModel->insertarPregunta($datosDePregunta, $idUsuario);
        $data['categoria'] = $this->categoriaModel->getAllCategories();
        $this->renderer->render("agregarPregunta",$data);
    }
        
        private function obtenerDatosDePregunta()
        {
            if(empty($_POST['pregunta']) || empty($_POST['opcCorrecta']) ||empty($_POST['resp2']) || empty($_POST['resp3']) ||
                empty($_POST['resp4']) || empty($_POST['categoria']) ){
                $data['error']= "Tiene que completar todos los campos";
                $data['categoria'] = $this->categoriaModel->getAllCategories();
                $this->renderer->render('agregarPregunta', $data);
                exit();
            }else{
               
               $data= [
                    'pregunta'=>$_POST['pregunta'],
                    'opcionA'=>$_POST['opcCorrecta'],
                    'opcionB'=>$_POST['resp2'],
                    'opcionC'=>$_POST['resp3'],
                    'opcionD'=>$_POST['resp4'],
                    'categoria'=>$_POST['categoria']
                ];
              return $data;
            }
        }
        
    }