<?php
    
    class RegisterModel
    {
        private $database;
        
        public function __construct($database)
        {
            $this->database = $database;
        }
        
        public function register($name, $lastName, $email, $birthDate, $genderId, $password, $userName)
        {
            return $this->database->
            execute("insert into usuario(nombre,apellido,correo,password,nombreUsuario, f_nacimiento, generoId )
                values('$name','$lastName','$email','$password','$userName','$birthDate','$genderId')");
        }
        
        
    }