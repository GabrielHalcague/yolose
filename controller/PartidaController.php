<?php

class PartidaController
{
    private mixed $render;
    private mixed $partidaModel;

    public function __construct($render, $partidaModel)
    {
        $this->render = $render;
        $this->partidaModel = $partidaModel;
    }
    public function list(): void
    {
        if(!empty(Session::get('perdiste'))){
            $this->salir();
        }
        $tipoPartida = $_GET['tipoPartida'] ?? '';
        if ($tipoPartida == '') {
            Header::redirect("/");
        }
        if (empty(Session::get('tipoPartida'))) {
            Session::set('tipoPartida', $tipoPartida);
        }
        if (empty(Session::get('tokenPartida'))) {
            Session::set('tokenPartida', uniqid());
        }

        $data = [
            'js' => true,
            'username' => Session::get('username'),
            'puntaje' => $this->partidaModel->obtenerScoreDelUsuario(Session::get('tokenPartida'), Session::get('username'))['puntos'] ?? 0
        ];

        if($tipoPartida == '2'){
            $data['tipoPartida'] = Session::get('tipoPartida');
        }

        if(empty(Session::get('respondio'))){
            Logger::info("EL USUARIO A RESPONDIDO LA PREGUNTA ANTERIOR O COMIENZO JUEGO");
            Session::set('respondio',true);
            $array=$this->comenzarJuego();
        }else{
            Logger::info("EL USUARIO REALIZO UN REDIRECCIONAMIENTO");
            $pregunta = Session::get('preguntaSeleccionada');
            $horaActual = time();
            $horaAnterior = Session::get('envioPregunta');
            $dif = $horaActual - $horaAnterior;
            if(empty(Session::get('tiempoRestante'))) {
                $tiempoRestante = 10 - $dif;
            }else{
                $tiempoRestante = Session::get('tiempoRestante') - $dif;
            }
            Session::set('tiempoRestante', $tiempoRestante);
            $array=[
                'pregunta' => $pregunta['pregunta'],
                'preguntaID' => $pregunta['preguntaID'],
                'color' => $pregunta['color'],
                'tiempo' => $tiempoRestante,
                'trampas' => Session::get('trampas'),
                'opc' => $this->partidaModel->obtenerRespuestaDePregunta($pregunta['preguntaID'])
            ];

        }

        // Realizar el envio de mail para que en el vsplayer, el otro usuario pueda jugar con el tokenPartida
        Session::set('envioPregunta', time());
        $this->render->render("jugar", array_merge($data,$array) );
    }


    public function verificar(): void
    {
        Logger::info("COMIENZA LA VERIFICACIÓN DE LA RESPUESTA");
        $id = $_POST['id'];
        if ($id == 'trampa') {
            $nTrampa = intval(Session::get('trampas')) - 1;
            Session::set('trampas', $nTrampa);
        }
        Session::deleteValue('respondio');
        Session::deleteValue('tiempoRestante');
        $data = $this->partidaModel->validarRespuesta([
            'seleccionUsuario' => $_POST['id'],
            'idUsuario' => Session::get('idUsuario'),
            'preguntaActual' => Session::get('preguntaSeleccionada'),
            'muestroPregunta' => Session::get('envioPregunta'),
            'respondioPregunta' => time(),
            'tokenPartida' => Session::get('tokenPartida'),
            'tipoPartida' => Session::get('tipoPartida')
        ]);
        
        if(!$data['correcto']){
            Session::set('perdiste' ,true);
        }

        $data['tipoPartida']=Session::get('tipoPartida');

        $response = array(
            'success' => true,
            'message' => 'Operación exitosa',
            'data' => $data // Puedes incluir datos adicionales si es necesario
        );

        echo json_encode($response);
    }

    public
    function partidaTerminada(): void
    {
        $tokenPartida = Session::get('tokenPartida');
        $tipoPartida = Session::get('tipoPartida');
        $scoreUsuario = $this->partidaModel->obtenerScoreDelUsuario($tokenPartida, Session::get('username'));
        $data = [
            'score' => $scoreUsuario['puntos'],
            'tipo' => $tipoPartida
        ];

        if ($tipoPartida == 2) {
            $maxPregBot = $this->partidaModel->obtenerPreguntasParaUsuario(-1);
            $scoreBot = rand(1, count($maxPregBot));
            $score = $scoreUsuario['puntos'];
            Logger::info("CANTIDAD DE RESPUESTAS DEL USUARIO [$score] - CANTIDAD DE RESPUESTAS DEL BOT [$scoreBot] ");
            if ($score > $scoreBot) {
                $resultado = "HAS GANADO AL BOT";
                Session::set('estadoPartida',1);
            } elseif ($score < $scoreBot) {
                $resultado = "HAS PERDIDO CON EL BOT";
                Session::set('estadoPartida',3);
            } else {
                $resultado = "HAS EMPATADO CON EL BOT";
                Session::set('estadoPartida',2);
            }
            $data['resultado'] = $resultado;
            $data['respuestasBot'] = $scoreBot;
        }

        if ($tipoPartida == 1) {
            $data['resultado'] = "BUENA SUERTE LA PROXIMA VEZ";
            Session::set('estadoPartida',0);
        }

        $response = array(
            'success' => true,
            'message' => 'Operación exitosa',
            'data' => $data // Puedes incluir datos adicionales si es necesario
        );
        echo json_encode($response);
    }

    public
    function salir(): void
    {
        Session::deleteValue('perdiste');
        Session::deleteValue('tokenPartida');
        Session::deleteValue('tipoPartida');
        Session::deleteValue('preguntas');
        Session::deleteValue('preguntaSeleccionada');
        Session::deleteValue('tiempo');
        Session::deleteValue('envioPregunta');
        Session::deleteValue('estadoPregunta');
        $trampasActuales = Session::get('trampas');
        Session::deleteValue('trampas');
        $this->partidaModel->actualizaTrampasUsuario($trampasActuales, Session::get('idUsuario'));
        Header::redirect("/");
    }

    public
    function comenzarJuego(): array
    {
        $preguntas = [];
        if (empty(Session::get('preguntas'))) {
            $preguntas = $this->partidaModel->obtenerPreguntasParaUsuario(Session::get('idUsuario')); //no tengo stock de preguntas y pido al modelo un stock
        } else {
            $preguntas = Session::get('preguntas'); // tengo stock
        }

        $indicePregunta = array_rand($preguntas);
        Session::set('preguntaSeleccionada', $preguntas[$indicePregunta]);
        if (empty(Session::get('trampas'))) {
            Session::set('trampas', $this->partidaModel->obtenerTrampasDelUsuario(Session::get('idUsuario'))['trampas']);
        }
        $data = [
            'pregunta' => $preguntas[$indicePregunta]['pregunta'],
            'preguntaID' => $preguntas[$indicePregunta]['preguntaID'],
            'color' => $preguntas[$indicePregunta]['color'],
            'tiempo' => 10,
            'trampas' => Session::get('trampas'),
            'opc' => $this->partidaModel->obtenerRespuestaDePregunta($preguntas[$indicePregunta]['preguntaID']),
        ];
        unset($preguntas[$indicePregunta]);
        Session::set('preguntas', $preguntas);
        return $data;
    }
    public function reportarPregunta(){
        $idPregunta= $_POST['preguntaId'];
        $idUsuario= Session::get('idUsuario');
        $this->partidaModel->reportarPregunta($idPregunta,$idUsuario);
    }
}

?>