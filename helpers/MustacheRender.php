<?php

class MustacheRender
{
    private $mustache;

    public function __construct($partialsPathLoader)
    {
        Mustache_Autoloader::register();
        $this->mustache = new Mustache_Engine(
            array(
                'partials_loader' => new Mustache_Loader_FilesystemLoader($partialsPathLoader)
            ));
    }

    public function render($contentFile, $data = array())
    {
        if (!empty(Session::get('logged')))
            $data['logged'] = Session::get('logged');
        if (!empty(Session::get('rol'))) {
            $data['rol'] = Session::get('rol');
            if ($data['rol'] == 'Editor') {
                $data['editor'] = true;
            } else {
                if ($data['rol'] == 'Administrador') {
                    $data['administrador'] = true;
                }
            }
        }
        if (!empty(Session::get('username')))
            $data['username'] = Session::get('username');
        echo $this->generateHtml($contentFile, $data);
    }

    public function generateTemplatedStringForEmail($template, $data = array())
    {
        $contentAsString = file_get_contents("public/template/" . $template . "_view.mustache");
        return $this->mustache->render($contentAsString, $data);
    }

    public function generateHtml($contentFile, $data = array())
    {

        $contentAsString = file_get_contents('view/partial/header.mustache');
        $contentAsString .= file_get_contents('view/' . $contentFile . '_view.mustache');
        $contentAsString .= file_get_contents('view/partial/footer.mustache');

        return $this->mustache->render($contentAsString, $data);
    }

    public function generateTemplatedStringForPDF($template, $data = [])
    {
        $contentAsString = file_get_contents("public/template/". $template . "_view.mustache");
        return $this->mustache->render($contentAsString, $data);
    }

    public function menuSegunElRol($data): array
    {
        if (isset($_SESSION['logged'])) {
            //$data['logged'] = Session::get('logged');

            $data['nombre'] = Session::get('nombre') ?? '';
            /*$data['ranking']="123";*/
        }
        return $data;
    }
}