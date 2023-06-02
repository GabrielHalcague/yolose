<?php

class PartidaController{


    private $render;
    private $partidaModel;

    public function __construct($render, $partidaModel)
    {
        $this->render = $render;
        $this->partidaModel = $partidaModel;
    }

    public function list(){
        if(!Session::getDataSession()){
            Header::redirect("/");
        }
        $preguntas=[];

        if(empty(Session::get('preguntas'))){
            $preguntas = $this->partidaModel->obtenerPreguntas(Session::get('username')); //no tengo stock de preguntas
        }else{
            $preguntas = Session::get('preguntas'); // tengo stock
        }

        if(empty($preguntas)){ // si ya respondio todas las preguntas
            $this->partidaModel->limpiarHistorialUsuario(Session::get('username')); //limpio el historial
            $preguntas = $this->partidaModel->obtenerPreguntas(Session::get('username')); // traer preguntas
        }
        $indicePregunta = array_rand($preguntas);
        $preguntaActual = $preguntas[$indicePregunta];

        $data['js']=true;
        $data['preg'] = [
            'pregunta' => $preguntaActual['preg']
        ];
        $data['logged'] = Session::get('logged');
        $data['username'] = Session::get('username');
        $data['opc'] = $this->partidaModel->obtenerRespuestaDePregunta($preguntaActual['id']);

        Session::set('preguntaSeleccionada',$preguntas[$indicePregunta]);
        /*unset($preguntas[$indicePregunta]);*/
        Session::set('preguntas',$preguntas);


        /*$index = array_search($preguntas[$indicePregunta], $preguntaActual);

        if ($index !== false) {
            array_splice($preguntas, $index, 1);
        }

        Session::set('preguntas',$preguntas);*/

        $this->render->render("jugar",$data);
    }


    //verifica comparando id enviado con id de respuesta correcta
    //depende si acierta o no devuelve uno o dos valores
    public function verificar(){

        $id = $_POST['id'];

        $preguntaSeleccionada = Session::get('preguntaSeleccionada');

        if($id == $preguntaSeleccionada['resCor']){
            $data['respValida'] = $preguntaSeleccionada['resCor'];
            //pregunta
        }
        else{
            $data['respValida'] = $preguntaSeleccionada['resCor'];
            $data['respActual'] = $id;
            //pregunta
        }
        //ir a historiaPartida, historialUsuario

        $response = array(
            'success' => true,
            'message' => 'Operación exitosa',
            'data' => $data // Puedes incluir datos adicionales si es necesario
        );

        echo json_encode($response);
    }

}