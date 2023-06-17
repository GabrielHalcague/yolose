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
        $data ["Ingresos"] = $this->AdministradorModel->getCantidadGananciaDeTrampasVendidasPorFecha( 'm', null, null)["arrays"][1][0];
        $data ["nuevosUsuariosMes"] = $this->AdministradorModel->getCantidadDeUsuariosNuevosPorFecha('m', null, null)["arrays"][1][0];
        $data ["preguntasNuevasDelMes"] = $this->AdministradorModel->getCantidadDePreguntasDisponiblesPorFecha('m', null, null)["arrays"][1][0];
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
                $data= $this->AdministradorModel->getCantidadDeUsuariosNuevosPorFecha($filtro,$fechaInicio,$fechaFin);
                break;
            case 8:
                $data= $this->AdministradorModel->getCantidadDeUsuariosNuevosPorFecha($filtro,$fechaInicio,$fechaFin);
                break;
            case 11:
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

    public function generarPDF(){ // no anda

        $base64String = $_POST['html']; // Obtén la cadena base64 desde la variable POST

        $decodedData = base64_decode($base64String); // Decodifica la cadena base64
        $html = '<html><body>';
        $html .= '<img src="data:image/png;base64,' . base64_encode($decodedData) . '" />';
        $html .= '</body></html>';
        $this->Dompdf->loadHtml($html);

// Renderiza el contenido HTML a PDF
        $this->Dompdf->render();

// Envía el archivo PDF al navegador para su descarga
        $this->Dompdf->stream('archivo.pdf');
       // (new PDFGenerator)->getPDF($decodedData,"asd");


    }


}