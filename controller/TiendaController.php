<?php

class TiendaController
{
    private mixed $renderer;
    private mixed $tiendaModel;
    private mixed $pdf;
    private mixed $pdfRender;

    public function __construct($renderer, $models)
    {
        $this->renderer = $renderer;
        $this->tiendaModel = $models['tiendaModel'];
        $this->pdf = $models['pdf'];
        $this->pdfRender = $models['pdfRender'];
    }

    public function list(){
        if(empty(Session::get('logged'))){
            Header::redirect("/");
        }
        $data['trampas'] = $this->tiendaModel->obtenerTodasLasTrampas();
        $data['jsTienda'] = true;
        $this->renderer->render("tienda", $data );
    }

    public function guardarPackSeleccionado(){
        $itemSeleccionado = $_POST['id'] ?? ' ';
        $item = $this->tiendaModel->obtenerTrampaPorId($itemSeleccionado);
        Logger::info("SE COMPRO EL ITEM #".$item['idTrampa']);
        if(empty($item)){
            $data['failure'] = true;
            Logger::error("EL ITEM ES VACIO");
        }else {
            $data['failure'] = false;
            Session::set('item', $item);
            Logger::error("EL ITEM NO ES VACIO");
        }
        $response = array(
            'success' => true,
            'message' => 'Operación exitosa',
            'data' => $data // Puedes incluir datos adicionales si es necesario
        );
        echo json_encode($response);
    }

    public function mostrarTarjeta(){
        if(empty(Session::get('logged'))){
            Header::redirect("/");
        }
        $item = Session::get('item');
        $data['producto'] = $item['descr'];
        $usuario = $this->tiendaModel->getUsuarioByID(Session::get('idUsuario'));
        $data['firstname'] = $usuario['nombre'];
        $data['surname'] = $usuario['apellido'];
        $this->renderer->render("tarjeta", $data );

    }

    public function confirmarPago(){
        $titular = $_POST['titular'];
        $nroTarjeta = $_POST['nroTarjeta'];

        if (empty($titular) || empty($nroTarjeta) || strlen($nroTarjeta) != 16 || empty($_POST['ccv']) || empty($_POST['vencimiento'])) {
            $data['error'] = 'Los datos ingresados son incorrectos';
            $this->renderer->render('tarjeta', $data);
        } else {
            $this->tiendaModel->registroPago([
                'idusuario' => Session::get('idUsuario'),
                'item' =>  Session::get('item')
            ]);
            $this->generarPDF();
        }
    }

        private function generarPDF()
        {
            $data = [
                'fecha' => date("Y-m-d"),
                'nombreCompleto' => $this->tiendaModel->getUsuarioByID(Session::get('idUsuario'))['nombreCompleto'],
                'email' => $this->tiendaModel->getUsuarioByID(Session::get('idUsuario'))['correo'],
                'productos' => Session::get('item')
            ];
            $html = $this->pdfRender->generateTemplatedStringForPDF('factura', $data);
            $this->pdf->getPDF($html, 'factura');
        }
}