<?php
    
    class RegisterModel
    {
        private $database;
        
        public function __construct($database)
        {
            $this->database = $database;
        }
        
        public function register($name, $lastName, $email, $birthDate, $genderId, $password, $userName,$namePhoto){
            $password= hash('md5',$password);
            return $this->database->
            execute("insert into usuario(nombre,apellido,correo,password,nombreUsuario,f_nacimiento,generoId,fotoPerfil )
                values('$name','$lastName','$email','$password','$userName','$birthDate','$genderId','$namePhoto')");
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

        
        
    }