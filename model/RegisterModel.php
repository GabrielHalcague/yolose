<?php
    
    class RegisterModel
    {
        private $database;
        
        public function __construct($database)
        {
            $this->database = $database;
        }
        
        public function register($name, $lastName, $email, $birthDate, $genderId, $password, $userName,$namePhoto, $f_registro){
            $password= hash('md5',$password);
            return $this->database->
            execute("insert into usuario(nombre,apellido,correo,password,nombreUsuario,f_nacimiento,generoId,fotoPerfil, f_registro )
                values('$name','$lastName','$email','$password','$userName','$birthDate','$genderId','$namePhoto','$f_registro')");
        }

        public function getUsuario($nickname, $password)
        {
            $password = hash('md5', $password);
            return $this->database->query("SELECT nombreUsuario FROM usuario
                                       WHERE nombreUsuario='$nickname'
                                       AND password='$password'");
        }


        public function getUsername($username){
            return $this->database->query("SELECT nombreUsuario FROM usuario WHERE nombreUsuario ='$username'");
        }

        public function getUserEmail($email)
        {
            return $this->database->query("SELECT correo FROM usuario
                                       WHERE correo ='$email'");
        }

        public function getUserByUsername($username){
            return $this->database->query("SELECT * FROM usuario
                                       WHERE nombreUsuario ='$username'");
        }

        public function getUserByID($id){
            return $this->database->query("SELECT * FROM usuario
                                       WHERE id ='$id'");
        }

        public function activarUsuario($id){
            $sql = "UPDATE usuario SET activo = 1 WHERE id = $id";
            $this->database->execute($sql);
        }

        
        
    }