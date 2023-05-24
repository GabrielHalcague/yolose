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
          //  "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')"
            return $this->database->
            execute("insert into usuario(nombre,apellido,correo,password,nombreUsuario )
                values('$name','$lastName','$email','$password','$userName')");
        }
        
        
    }