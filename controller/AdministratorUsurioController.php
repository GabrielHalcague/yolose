<?php

class AdministratorUsurioController
{
    private $renderer;
    private $AdministradorUsuarioModel;

    public function __construct($renderer , $AdministradorUsuarioModel)
    {   $this->renderer = $renderer;
        $this->AdministradorUsuarioModel = $AdministradorUsuarioModel;

    }
    public function list(){
        if(session::get("rol") !="Administrador" ){
            Header::redirect("/");
        }
        $data =[];
        $data["administradorJS"]=true;
        $this->renderer->render("administradorUsuario", $data);
    }

    public function consultar(){
        if(session::get("rol") !="Administrador" ){
            Header::redirect("/");
        }
        $data=[];
        if(!isset($_POST['usuario']) && empty($_POST['usuario'])){
            $data['error']= 'formato Invalido';
            $this->renderer->render('administradorUsuario', $data);
        }
        $username = $_POST['usuario'];
        $data["usuario"] = $this->AdministradorUsuarioModel->getDatosDelUsuario($username);
        if(is_null($data["usuario"])){
            $data['error']= 'Usuario no Encontrado';
        }
            $this->renderer->render('administradorUsuario', $data);
    }
    public function consultaPorId() {
        if(session::get("rol") !="Administrador" ){
            Header::redirect("/");
        }
        $tipoConsulta = $_POST['tipoConsulta']?? 1;
        $f_inicio = $_POST['fechaInicio']?? null;
        $f_fin = $_POST["fechaFin"] ?? null;
        $filtro = $_POST["filtro"] ?? 'd';
        $usuarioId = $_POST["usuarioId"] ?? '1';
        $data =[];
        switch ($tipoConsulta){
            case 1:
                $data= $this->AdministradorUsuarioModel->getTrampitasAcumuladasPorElUsuario($usuarioId , $filtro,$f_inicio,$f_fin);
                break;
            case 2:
                $data= $this->AdministradorUsuarioModel->getPorcentajeDePreguntasRespondidasCorrectamentePorElUsuario($usuarioId, $filtro,$f_inicio,$f_fin);
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
            $this->Dompdf->loadHtml('<html><body><h2>'. $titulo .'</h2><img src="' . $tmpFilePath . '"></body></html>');
            $this->Dompdf->setPaper('A4', 'portrait');
            $this->Dompdf->render();
            $this->Dompdf->stream('Estadistica '.date('Y-m-d').'.pdf', ['Attachment' => true]);

        } else {

            echo 'Error: No se recibieron los datos de la imagen.';
        }
    }

}