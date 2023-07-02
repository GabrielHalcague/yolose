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

    public function list($data = null)
    {
        if (Session::get('rol') == 'Usuario') {
            Header::redirect("/");
        }

        if (!empty($_POST['mensaje'])) {
            $data['mensaje'] = $_POST['mensaje'];
        }

        $data['categoria'] = $this->categoriaModel->getAllCategories();
        $this->renderer->render('categoria', $data);
    }

    public function nuevaCategoria()
    {
        if (Session::get('rol') == 'Usuario') {
            Header::redirect("/");
        }
        $this->renderer->render("nuevaCategoria");
    }

    public function modificarCategoria()
    {
        if (Session::get('rol') == 'Usuario') {
            Header::redirect("/");
        }
        if (empty($_GET['id'])) {
            Header::redirect("/");
        }
        $data = $this->categoriaModel->getCategoryById($_GET['id']);
        if (empty($data)) {
            Header::redirect("categoria");
        }
        $this->renderer->render("editarCategoria", $data);
        exit();
    }

    public function editarCategoria()
    {
        $datosCategoria = $this->validarDatosDeCategoria();
        $data = $this->categoriaModel->editarCategoria($datosCategoria);
        $this->list($data);
    }

    public function agregarCategoria()
    {
        $datosCategoria = $this->validarNuevaCategoria();
        $data = $this->categoriaModel->agregarCategoria($datosCategoria);
        $this->list($data);
    }

    public function eliminarCategoria()
    {
        if (Session::get('rol') == 'Usuario') {
            Header::redirect("/");
        }
        if (empty($_GET['id'])) {
            Header::redirect("/");
        }
        $data = $this->categoriaModel->eliminarCategoria($_GET['id']);
        $this->list($data);

    }

    private function validarDatosDeCategoria()
    {
        if (empty($_POST['categoriaNombre']) || empty($_POST['categoriaColor'])) {
            $data['mensaje'] = "Tiene que completar todos los campos.";
            $this->renderer->render('nuevaCategoria', $data);
            exit();
        } else {
            return [
                'id' => $_POST['id'],
                'categoriaNombre' => $_POST['categoriaNombre'],
                'categoriaColor' => $_POST['categoriaColor']
            ];
        }
    }

    
    private function validarNuevaCategoria()
    {
        if (empty($_POST['categoriaNombre']) || empty($_POST['categoriaColor'])) {
            $data['mensaje'] = "Tiene que completar todos los campos.";
            $this->renderer->render('nuevaCategoria', $data);
            exit();
        } else {
            return [
                'categoriaNombre' => $_POST['categoriaNombre'],
                'categoriaColor' => $_POST['categoriaColor']
            ];
        }
    }

}