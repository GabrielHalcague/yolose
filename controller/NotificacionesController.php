<?php

class NotificacionesController{

    private $notificacionesModel;

    public function __construct($notificacionesModel)
    {
        $this->notificacionesModel = $notificacionesModel;

    }
    public function notificaciones(){
        if (empty(Session::get('logged'))) {
            Header::redirect("/");
        }
        $idUsuario = Session::get('idUsuario');
        $partidasPendientes = $this->notificacionesModel->getCantidadDEPartidasPendientesPorIdUsuario($idUsuario);
        header('Content-Type: application/json');
        echo json_encode($partidasPendientes);

    }



}