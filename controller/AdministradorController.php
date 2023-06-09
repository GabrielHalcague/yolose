<?php



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
    public function list($data = null){
        if(session::get("rol") !="Administrador" ){
            Header::redirect("/");
        }

        $data ["Ingresos"] = $this->AdministradorModel->getCantidadDeTrampasVendidasPorFecha( 'm', null, null)[0]['cantidad'];
        $data ["nuevosUsuariosMes"] = $this->AdministradorModel->getCantidadDeUsuariosNuevosPorFecha('m')[0]['cantidad'];
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
        $usuarioId = $_POST["usuarioId"] ?? '1';
        $data =[];

        try {
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
                $data= $this->AdministradorModel->getCantidadDeTrampasVendidasPorFecha($filtro,$fechaInicio,$fechaFin);
                break;
            case 11:
                $data= $this->AdministradorModel->getTrampitasAcumuladasPorElUsuario($usuarioId , $filtro, $fechaInicio, $fechaFin);
                break;
            case 12:
                $data= $this->AdministradorModel->getPorcentajeDePreguntasRespondidasCorrectamentePorElUsuario($usuarioId, $filtro, $fechaInicio, $fechaFin);
                break;
        }
          echo json_encode($data);
         // throw new Exception("Este es un mensaje de error.");
        }
        catch (Exception $e) {
            http_response_code(503);
            header('Content-Type: text/plain; charset=utf-8');
            echo $e->getMessage();
        }
    }

    public function cambiarRol(){
        if(session::get("rol") !="Administrador" ){
            Header::redirect("/");
        }
        $nombreUsuario = $_GET['nombreUsuario'];
        $rol = $_GET['rol'];
        $this->AdministradorModel->setCambiarRolPorNombreUsuario($nombreUsuario, $rol);
        $data["usuario"] = $this->AdministradorModel->getDatosDelUsuario($nombreUsuario);
        $this->list($data);
    }

    public function buscarUsuario(){
        if(session::get("rol") !="Administrador" ){
            Header::redirect("/");
        }

        if(empty($_POST['usuario'])){
            $data['error']= 'formato Invalido';
            $this->list($data);
        }

        $username = $_POST['usuario'];

        try {
            $data["usuario"] = $this->AdministradorModel->getDatosDelUsuario($username);

            if (is_null($data["usuario"])) {
                $data['error'] = 'Usuario no Encontrado';
            }

            $this->list($data);
        } catch (Exception $e) {
            $data['error'] = 'exepcion en bd: ' . $e->getMessage();
            $this->list($data);
        }
    }

    
    public function generarPDF() {
        if(session::get("rol") !="Administrador" ){
            Header::redirect("/");
        }
        if (isset($_POST['imageData'])) {
            $imageData = $_POST['imageData'];
            $titulo = $_POST['consulta'];
            $tabla =  json_decode($_POST['datosTabla'], true );
            $tmpFilePath = 'public/imagepdf.png';
            file_put_contents($tmpFilePath, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData)));
            // Generar el PDF utilizando Dompdf

            $html = file_get_contents('public/template/estadisticas_view.mustache');
            $data ['titulo']=$titulo;
            $data ['imagen']=$tmpFilePath;
            $data ['tabla']=$tabla;

            $mustache = new Mustache_Engine();
            $htmlRenderizado = $mustache->render($html, $data);

            $this->Dompdf->loadHtml($htmlRenderizado);
            $this->Dompdf->setPaper('A4', 'portrait');
            $this->Dompdf->render();
            $this->Dompdf->stream('Estadistica '.date('Y-m-d').'.pdf', ['Attachment' => true]);

        } else {
            echo 'Error: No se recibieron los datos de la imagen.';
        }
    }

}