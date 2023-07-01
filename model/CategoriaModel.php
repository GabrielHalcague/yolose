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

    public function getCategoryByName($name){
        $sql = "SELECT * FROM categoria WHERE categ = '$name'";
        return $this->database->query_row($sql);
    }

    public function editarCategoria($datosCategoria){

        $this->actualizarCategoria([
            $this->obtenerIdCategoria($datosCategoria['categoriaNombre']),
            $datosCategoria['categoriaNombre'],
            $datosCategoria['categoriaColor']
        ]);
        return [
            'mensaje' => 'Categoria Actualizada'
        ];
    }

    public function eliminarCategoria($name){

        $data = $this->getCategoryByName($name);
        if(empty($data)){
            $data['mensaje'] = 'No Existe esa categoria';
        }
        if($this->getCountQuestionByCategory($data['id']) == 1){
            $data['mensaje'] = 'No se puede eliminar la categoria, elimine las preguntas asociadas';
        }
        $this->quitarCategoria($data['id']);
    }

    private function getCountQuestionByCategory($id){
        $sql= "SELECT 1 FROM pregunta WHERE idCat = '$id'";
        return $this->database->SoloValorCampo($sql);
    }

    public function agregarCategoria($datosCategoria){
        /*$idCategoria= $this->obtenerIdCategoria($datosCategoria['categoriaNombre']);
        if($idCategoria==0){
            $nombreColor = $this->obtenerNombreColorCategoriaColor($datosCategoria['idCategoriaColor']);
            $this->agregarCategoriaNueva($datosCategoria['categoriaNombre'], $nombreColor);
            $this->actualizarCategoriaColor($datosCategoria['idCategoriaColor']);
        }*/
        if(!empty($this->getCategoryByName($datosCategoria['categoriaNombre']))){
            $data['mensaje'] = 'La categoria ingresada ya existe en nuestro sistema';
        }else{
            $this->agregarCategoriaNueva($datosCategoria['categoriaNombre'],$datosCategoria['categoriaColor']);
            $data['mensaje'] = 'Se ha insertado con exito la nueva categoria';
        }
        return $data;
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

    /*public function actualizarCategoriaColor($data){
        $sql = "UPDATE categoriaColor SET activo = 0
                WHERE id = '$data[0]'";
        $this->database->execute($sql);
    }*/
    private function actualizarCategoria($array): void
    {
        $sql = "UPDATE categoria c 
                SET c.categ = '$array[1]',
                    c.color = '$array[2]'
                WHERE c.id = '$array[0]'";
        $this->database->execute($sql);
    }

    private function quitarCategoria($id): void
    {
        $sql = "DELETE FROM categoria WHERE id = '$id'";
        $this->database->execute($sql);
    }

}