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

        // Realizar el envio de mail para que en el vsplayer, el otro usuario pueda jugar con el tokenPartida
        Session::set('mostrarPregunta', (new DateTime)->getTimestamp());
        $this->render->render("jugar", $this->comenzarJuego());
    }


    public function verificar(): void
    {
        Logger::info("COMIENZA LA VERIFICACIÓN DE LA RESPUESTA");
        $id = $_POST['id'];
        if ($id == 'trampa') {
            $nTrampa = intval(Session::get('trampas')) - 1;
            Session::set('trampas', $nTrampa);
        }
        $data = $this->partidaModel->validarRespuesta([
            'seleccionUsuario' => $_POST['id'],
            'idUsuario' => Session::get('idUsuario'),
            'preguntaActual' => Session::get('preguntaSeleccionada'),
            'muestroPregunta' => Session::get('mostrarPregunta'),
            'respondioPregunta' => (new DateTime)->getTimestamp(),
            'tokenPartida' => Session::get('tokenPartida')
        ]);

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
        $scoreUsuario = $this->partidaModel->obtenerScoreDelUsuario($tokenPartida);
        $data['score'] = $scoreUsuario[0]['puntos'];
        $data['tipo'] = $tipoPartida;
        if ($tipoPartida == 'vsbot') {
            $maxPregBot = $this->partidaModel->obtenerPreguntasParaUsuario('boot');
            $scoreBot = rand(1, count($maxPregBot));
            if ($scoreUsuario > $scoreBot) {
                $resultado = "HAS GANADO AL BOT";
            } elseif ($scoreUsuario < $scoreBot) {
                $resultado = "HAS PERDIDO CON EL BOT";
            } else {
                $resultado = "HAS EMPATADO CON EL BOT";
            }
            $data['resultado'] = $resultado;
        }

        /*if ($tipoPartida == 'vsplayer') {
            $arrayScores = $this->partidaModel->obtenerScoresDeUnVsPlayer($tokenPartida);
            if (count($arrayScores) == 1) {
                $usuarioGanador = array_keys(max($arrayScores));
               $data['resultado'] = $usuarioGanador;
            }
        }*/

        if ($tipoPartida == 'solitario') {
            $data['resultado'] = "HAS MEJORADO";
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
        Session::deleteValue('tokenPartida');
        Session::deleteValue('tipoPartida');
        Session::deleteValue('preguntas');
        Session::deleteValue('preguntaSeleccionada');
        $trampasActuales = Session::get('trampas');
        Session::deleteValue('trampas');
        $this->partidaModel->actualizaTrampasUsuario($trampasActuales,Session::get('idUsuario'));
        Header::redirect("/");
    }

    public
    function comenzarJuego(): array
    {
        $preguntas = [];
        if (empty(Session::get('preguntas'))) {
            $preguntas = $this->partidaModel->obtenerPreguntasParaUsuario(Session::get('username')); //no tengo stock de preguntas y pido al modelo un stock
        } else {
            $preguntas = Session::get('preguntas'); // tengo stock
        }

        $indicePregunta = array_rand($preguntas);
        Session::set('preguntaSeleccionada', $preguntas[$indicePregunta]);
        if(empty(Session::get('trampas'))){
            Session::set('trampas',$this->partidaModel->obtenerTrampasDelUsuario(Session::get('idUsuario'))[0]['trampas']);
        }
        $data = [
            'js' => true,
            'pregunta' => $preguntas[$indicePregunta]['pregunta'],
            'color' => $preguntas[$indicePregunta]['color'],
            'logged' => Session::get('logged'),
            'username' => Session::get('username'),
            'opc' => $this->partidaModel->obtenerRespuestaDePregunta($preguntas[$indicePregunta]['preguntaID']),
            'trampas' => Session::get('trampas') ?? 5,
            'tipoPartida' => Session::get('tipoPartida'),
            'puntaje' => $this->partidaModel->obtenerScoreDelUsuario(Session::get('tokenPartida'))[0]['puntos'] ?? 0
        ];
        unset($preguntas[$indicePregunta]);
        Session::set('preguntas', $preguntas);
        return $data;
    }
}

?>