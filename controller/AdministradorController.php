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
        $data ["administradorJS"] = true;
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
                $data = $this->AdministradorModel->getCantidadDeUsuariosPorPais($filtro,$fechaInicio,$fechaFin);
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


    public function generarPDF() {
        if(session::get("rol") !="Administrador" ){
            Header::redirect("/");
        }
        if (isset($_POST['imageData'])) {
            $imageData = $_POST['imageData'];
            $titulo = $_POST['consulta'];
            $tmpFilePath = 'public/imagepdf.png';
            file_put_contents($tmpFilePath, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData)));
            // Generar el PDF utilizando Dompdf
            $this->Dompdf->loadHtml('<html><body><h2>'. $titulo .'</h2><img src="' . $tmpFilePath . '" style="width: 100%;"></body></html>');
            $this->Dompdf->setPaper('A4', 'portrait');
            $this->Dompdf->render();
            $this->Dompdf->stream('Estadistica '.date('Y-m-d').'.pdf', ['Attachment' => true]);

        } else {

            echo 'Error: No se recibieron los datos de la imagen.';
        }
    }

}