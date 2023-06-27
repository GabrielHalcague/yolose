<?php

class CategoriaModel{


    private $database;

    public function __construct($database){
        $this->database = $database;
    }

    public function getAllCategories(){
        return $this->database->query("SELECT id, categ FROM categoria");
    }

    public function getAllCategoriesCollors(){
        return $this->database->query("SELECT id,descripcion FROM categoriaColor WHERE activo = 1");
    }

    public function agregarCategoria($datosCategoria){
        $idCategoria= $this->obtenerIdCategoria($datosCategoria['categoriaNombre']);
        if($idCategoria==0){
            $nombreColor = $this->obtenerNombreColorCategoriaColor($datosCategoria['idCategoriaColor']);
            $this->agregarCategoriaNueva($datosCategoria['categoriaNombre'], $nombreColor);
            $this->actualizarCategoriaColor($datosCategoria['idCategoriaColor']);
        }
    }

    public function obtenerIdCategoria($categoriaNombre){
        $sql = "SELECT id FROM categoria WHERE categ LIKE '$categoriaNombre'";
        $result= $this->database->query_row($sql);
        if($result!=null){
            return $result['id'];
        }
        return 0;
    }

    public function obtenerNombreColorCategoriaColor($idCategoriaColor){
        $sql = "SELECT color FROM categoriaColor WHERE id = '$idCategoriaColor'";
        $result = $this->database->query_row($sql);
        return $result['color'];
    }

    public function agregarCategoriaNueva($nombreCategoria,$nombreColor){
        $sql = "INSERT INTO categoria (categ,color)
                VALUES ('$nombreCategoria','$nombreColor')";
        $this->database->execute($sql);
    }

    public function actualizarCategoriaColor($data){
        $sql = "UPDATE categoriaColor SET activo = 0
                WHERE id = '$data[0]'";
        $this->database->execute($sql);
    }

}