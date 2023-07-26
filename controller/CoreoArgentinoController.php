<?php

class CoreoArgentinoController
{
    private $renderer;
    private  $Dompdf;
    public function __construct($renderer, $Dompdf)
    {
        $this->renderer = $renderer;
        $this->Dompdf= $Dompdf;
    }

    public function list()
    {
       $this->renderer->render("correoArgentino");
    }

    public function validarDatos(){
        $datos['errores'] = "";
        $datos['remitente'] = $_POST['remitente'] ?? "*";
        $datos['rDomicilio'] = $_POST['rDomicilio'] ?? "*";
        $datos['rCP'] = $_POST['rCP'] ?? "*";
        $datos['rLocalidad'] = $_POST['rLocalidad'] ?? "*";
        $datos['rProvincia'] = $_POST['rProvincia'] ?? "*";
        $datos['destinatario']  = $_POST['destinatario'] ?? "*";
        $datos['dDomicilio']  = $_POST['dDomicilio'] ?? "*";
        $datos['dCP']  = $_POST['dCP'] ?? "*";
        $datos['dLocalidad']  = $_POST['dLocalidad'] ?? "*";
        $datos['dProvincia']  = $_POST['dProvincia'] ?? "*";

        $datos ['texto']=$_POST['formattedContent'];
        foreach ($datos as $lakey => $fila) {
            if ($fila == '*') {
                $datos['errores'] .= $lakey . ': ' . $fila;
            }
        }
        return $datos;
    }

    public function procesar(){
        $datos = $this->validarDatos();
             if( strlen( $datos['errores']) >0){
            $this->renderer->render('/correoArgentino', $datos);
        }else{

        $html = file_get_contents('public/template/CDCorreoArgentino_view.mustache');
        $mustache = new Mustache_Engine();
        $htmlRenderizado = $mustache->render($html, $datos);

        $this->Dompdf->loadHtml($htmlRenderizado);
                 $this->Dompdf->setpaper(array(0, 0, 614.295, 1011.78), 'portrait');
        $this->Dompdf->render();
        $this->Dompdf->stream('CD '.date('Y-m-d').'.pdf', ['Attachment' => true]);
        $this->list();
        exit();
        }

    }

}