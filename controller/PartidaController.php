<?php

class PartidaController
{
    private $render;
    private $partidaModel;

    public function __construct($render, $partidaModel)
    {
        $this->render = $render;
        $this->partidaModel = $partidaModel;
    }

    public function list()
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
        $data = $this->partidaModel->validarRespuesta([
            'seleccionUsuario' => $_POST['id'],
            'username' => Session::get('username'),
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

    public function partidaTerminada(): void
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

    public function salir()
    {
        Session::deleteValue('tokenPartida');
        Session::deleteValue('tipoPartida');
        Session::deleteValue('preguntas');
        Session::deleteValue('preguntaSeleccionada');
        Header::redirect("/");
    }

    public function comenzarJuego(): array
    {
        $preguntas = [];
        if (empty(Session::get('preguntas'))) {
            $preguntas = $this->partidaModel->obtenerPreguntasParaUsuario(Session::get('username')); //no tengo stock de preguntas y pido al modelo un stock
        } else {
            $preguntas = Session::get('preguntas'); // tengo stock
        }

        $indicePregunta = array_rand($preguntas);
        Session::set('preguntaSeleccionada', $preguntas[$indicePregunta]);
        $data = [
            'js' => true,
            'pregunta' => $preguntas[$indicePregunta]['pregunta'],
            'color' => $preguntas[$indicePregunta]['color'],
            'logged' => Session::get('logged'),
            'username' => Session::get('username'),
            'opc' => $this->obtenerRespuestaDePregunta($preguntas[$indicePregunta]['preguntaID']),
            'trampas' => 5,
            'tipoPartida' => Session::get('tipoPartida')
        ];
        unset($preguntas[$indicePregunta]);
        Session::set('preguntas', $preguntas);
        return $data;
    }

    private function obtenerRespuestaDePregunta(mixed $preguntaID)
    {
        return $this->partidaModel->obtenerRespuestaDePregunta($preguntaID);
    }


}

?>