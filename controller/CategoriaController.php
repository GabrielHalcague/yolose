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
        if(empty(Session::getDataSession())){
            Header::redirect("/");
        }

        $data['categoriaColor'] = $this->categoriaModel->getAllCategoriesCollors();
        $this->renderer->render('categoria',$data);
    }

    public function agregarCategoria()
    {
        $datosCategoria = $this->obtenerDatosCategoria();
        $this->categoriaModel->agregarCategoria($datosCategoria);
        $data['categoriaColor'] = $this->categoriaModel->getAllCategoriesCollors();
        $data['mensaje'] = "Categoria agregada exitosamente.";
        $this->renderer->render("categoria",$data);
    }


    private function obtenerDatosCategoria()
    {
        if(empty($_POST['categoriaNombre']) || empty($_POST['idCategoriaColor'])){
            $data['mensaje']= "Tiene que completar todos los campos.";
            $data['categoriaColor'] = $this->categoriaModel->getAllCategoriesCollors();
            $this->renderer->render('categoria', $data);
            exit();
        }else{

            $data= [
                'categoriaNombre'=>$_POST['categoriaNombre'],
                'idCategoriaColor'=>$_POST['idCategoriaColor']
            ];
            return $data;
        }
    }

}