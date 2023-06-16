<?php

class AdministradorController
{
    private $renderer;
    private $AdministradorModel;
    public function __construct($renderer, $AdministradorModel)
    {
        $this->renderer =$renderer;
        $this->AdministradorModel = $AdministradorModel;

    }
    public function list(){

        if(session::get("rol") !="Administrador" ){
            Header::redirect("/");
        }
        $data ["nuevosUsuariosMes"] = $this->AdministradorModel->getCantidadDeUsuariosNuevosDeEsteMEs();
        $data ["usuariosTotales"] = $this->AdministradorModel->getCantidadDeUsuariosTotales();
      //  $data ["cantidadDePartidasJugadas"] = $this->AdministradorModel->getCantidadPartidasJugadasPorFecha();
        return $this->renderer->render("administrador",$data);
    }

    public function consultaPorTipo() {
        $tipoConsulta = $_POST['tipoConsulta']?? 1;
        $fechaInicio = $_POST['fechaInicio']?? null;
        $fechaFin = $_POST["fechaFin"] ?? null;
        $filtro = $_POST["filtro"] ?? 'd';
        $data =[];
        switch ($tipoConsulta){
            case 1:

                break;
        }
        $data= $this->AdministradorModel->getCantidadPartidasJugadasPorFecha($filtro,$fechaInicio,$fechaFin);

        echo json_encode($data);
    }


}