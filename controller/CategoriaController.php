<?php

class CategoriaController
{
    private $renderer;

    private $categoriaModel;

    public function __construct($renderer, $models)
    {
        $this->renderer = $renderer;
        $this->categoriaModel = $models['categoria'];
    }

    public function list()
    {
        if(Session::get('rol') == 'Usuario'){
            Header::redirect("/");
        }

        if(!empty($_POST['mensaje'])){
            $data['mensaje'] = $_POST['mensaje'];
        }

        $data['categoria'] = $this->categoriaModel->getAllCategories();
        $this->renderer->render('categoria',$data);
    }

    public function nuevaCategoria()
    {
        if(Session::get('rol') == 'Usuario'){
            Header::redirect("/");
        }
        $this->renderer->render("nuevaCategoria");
    }

    public function modificarCategoria(){
        if(Session::get('rol') == 'Usuario'){
            Header::redirect("/");
        }
        if(empty($_GET['name'])){
            Header::redirect("/");
        }
        $data = $this->categoriaModel->getCategoryByName($_GET['name']);
        if(empty($data)){
            Header::redirect("categoria");
        }
        $this->renderer->render("editarCategoria",$data);
        exit();
    }

    public function editarCategoria()
    {
        $datosCategoria = $this->obtenerDatosCategoria();
        $data = $this->categoriaModel->editarCategoria($datosCategoria);
        //$this->renderer->render("categoria",$data);
        Header::redirect("categoria?mensaje=".$data['mensaje']);
    }

    public function agregarCategoria()
    {
        $datosCategoria = $this->obtenerDatosCategoria();
        $data = $this->categoriaModel->agregarCategoria($datosCategoria);
        $this->renderer->render("categoria",$data);
        Header::redirect("categoria?mensaje=".$data['mensaje']);
    }

    public function eliminarCategoria(){
        if(Session::get('rol') == 'Usuario'){
            Header::redirect("/");
        }
        if(empty($_GET['name'])){
            Header::redirect("/");
        }
        $this->categoriaModel->eliminarCategoria($_GET['name']);
        Header::redirect("categoria");
    }

    private function obtenerDatosCategoria()
    {
        if(empty($_POST['categoriaNombre']) || empty($_POST['categoriaColor'])){
            $data['mensaje']= "Tiene que completar todos los campos.";
            $this->renderer->render('nuevaCategoria', $data);
            exit();
        }else{
            return [
                'categoriaNombre'=>$_POST['categoriaNombre'],
                'categoriaColor'=>$_POST['categoriaColor']
            ];
        }
    }

}