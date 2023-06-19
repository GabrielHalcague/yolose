<?php

use Dompdf\Dompdf;

class AdministradorController
{
    private $renderer;
    private $AdministradorModel;
    private  $Dompdf;

    public function __construct($renderer, $AdministradorModel ,$pdf)
    {
        $this->renderer =$renderer;
        $this->AdministradorModel = $AdministradorModel;
        $this->Dompdf =$pdf;

    }
    public function list(){
        if(session::get("rol") !="Administrador" ){
            Header::redirect("/");
        }
        $data ["Ingresos"] = $this->AdministradorModel->getCantidadGananciaDeTrampasVendidasPorFecha( 'm', null, null)[0]['cantidad'];
        $data ["nuevosUsuariosMes"] = $this->AdministradorModel->getCantidadDeUsuariosNuevosPorFecha('m', null, null)[0]['cantidad'];
        $data ["preguntasNuevasDelMes"] = $this->AdministradorModel->getCantidadDePreguntasDisponiblesPorFecha('m', null, null)[0]['cantidad'];
        return $this->renderer->render("administrador",$data);
    }

    public function consultaPorTipo() {
        if(session::get("rol") !="Administrador" ){
            Header::redirect("/");
        }
        $tipoConsulta = $_POST['tipoConsulta']?? 1;
        $fechaInicio = $_POST['fechaInicio']?? null;
        $fechaFin = $_POST["fechaFin"] ?? null;
        $filtro = $_POST["filtro"] ?? 'd';
        $data =[];
        switch ($tipoConsulta){
            case 1:
                $data= $this->AdministradorModel->getCantidadPartidasJugadasPorFecha($filtro,$fechaInicio,$fechaFin);
                break;
            case 2:
                $data= $this->AdministradorModel->getCantidadDePreguntasEnElJuegoPorFecha($filtro,$fechaInicio,$fechaFin);
                break;
            case 3:
                $data= $this->AdministradorModel->getCantidadDePreguntasDisponiblesPorFecha($filtro,$fechaInicio,$fechaFin);
                break;
            case 4:
                $data= $this->AdministradorModel->getCantidadDeUsuariosNuevosPorFecha($filtro,$fechaInicio,$fechaFin);
                break;
            case 5:
                break;
            case 6:
                $data= $this->AdministradorModel->getCantidadDeUsuariosPorSexo($filtro,$fechaInicio,$fechaFin);
                break;
            case 7:
                $data= $this->AdministradorModel->getCantidadDeUsuariosPorRangoDeEdad($filtro,$fechaInicio,$fechaFin);
                break;
            case 8:
                $data= $this->AdministradorModel->getCantidadGananciaDeTrampasVendidasPorFecha($filtro,$fechaInicio,$fechaFin);
                break;
        }
        $error=0;
        if ($error>0) {
            http_response_code(503);
            header('Content-Type: text/plain; charset=utf-8');
            echo ($filtro);

        }else{
            echo json_encode($data);
        }
    }


    public function generarPDF()
    {
        $html = $_POST['imageData'];
        $this->Dompdf->getPDF($html, 'factura');
        $this->Dompdf->addPage();

// Agrega la imagen desde el contenido del canvas
        $this->Dompdf->addImageFromDataUrl($html);

// Genera el contenido del PDF
        $pdfContent = $this->Dompdf->output();
// Devuelve el contenido del PDF como respuesta
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="resultado.pdf"');
        echo $pdfContent;

    }

}