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
        $data['logged'] = Session::get('logged');
        $data['categoria'] = $this->categoriaModel->getAllCategories();
        $this->renderer->render("ingreso",$data);
    }

    public function agregarPregunta(){
        $cError = 0;
        $pregunta = $_POST['preg'] ?? '';
        if($pregunta == ''){
            $cError ++;
            $data['errorPregunta'] = "la pregunta no debe ser vacia";
        }
        $categoria = $_POST['cate'] ?? '';
        if($categoria == ''){
            $cError ++;
            $data['errorCategoria'] = "categoria invalida";
        }
        $resp1 = $_POST['resp1'] ?? '';
        if($resp1 == ''){
            $cError ++;
            $data['errorResp1'] = "La respuesta 1 no puede ser vacio";
        }
        $resp2 = $_POST['resp2'] ?? '';
        if($resp1 == ''){
            $cError ++;
            $data['errorResp2'] = "La respuesta 2 no puede ser vacio";
        }
        $resp3 = $_POST['resp3'] ?? '';
        if($resp1 == ''){
            $cError ++;
            $data['errorResp3'] = "La respuesta 3 no puede ser vacio";
        }
        $resp4 = $_POST['resp4'] ?? '';
        if($resp1 == ''){
            $cError ++;
            $data['errorResp4'] = "La respuesta 4 no puede ser vacio";
        }

        if($cError == 0){
            $this->preguntaModel->agregarPregunta([$pregunta,$categoria]);
            $id = $this->preguntaModel->obtenerIdPregunta($pregunta)[0];
            $this->respuestaModel->agregarRespuestas([$resp1,$resp2,$resp3,$resp4],$id);
            Header::redirect("/");
        }else{
            $this->renderer->render("ingreso",$data);
        }
    }

}