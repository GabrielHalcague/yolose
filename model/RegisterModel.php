<?php
    
    class RegisterModel
    {
        private $database;
        
        public function __construct($database)
        {
            $this->database = $database;
        }
        
        public function register($name, $lastName, $email, $birthDate, $genderId, $password, $userName,$namePhoto,$coordenadas){
            $password= hash('md5',$password);
            return $this->database->
            execute("insert into usuario(`nombre`, `apellido`, `nombreUsuario`, `password`, `generoId`, `correo`, `fotoPerfil`, `f_nacimiento`, `coordenadas`, `activo`, `trampas`)
            VALUES ('$name', '$lastName', '$userName', '$password', '$genderId', '$email', '$namePhoto', '$birthDate', '$coordenadas',  NULL, '0')");
        }

        public function getUsuario($nickname, $password)
        {
            $password = hash('md5', $password);
            return $this->database->query_row("SELECT nombreUsuario FROM usuario
                                       WHERE nombreUsuario='$nickname'
                                       AND password='$password'");
        }


        public function getUsername($username){
            return $this->database->query_row("SELECT nombreUsuario FROM usuario WHERE nombreUsuario ='$username'");
        }

        public function getUserEmail($email)
        {
            return $this->database->query_row("SELECT correo FROM usuario
                                       WHERE correo ='$email'");
        }

        public function getUserByUsername($username){
            return $this->database->query_row("SELECT * FROM usuario
                                       WHERE nombreUsuario ='$username'");
        }

        public function getUserByID($id){
            return $this->database->query_row("SELECT * FROM usuario
                                       WHERE id ='$id'");
        }

        public function activarUsuario($id){
            $sql = "UPDATE usuario SET activo = 1 WHERE id = $id";
            $this->database->execute($sql);
        }

        public function setRol($id){
            $sql = "INSERT INTO rol_usuario(idUs, idRol) VALUES ('$id', 3)";
            $this->database->execute($sql);
        }


        
    }