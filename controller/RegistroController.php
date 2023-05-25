<?php
    
    class RegistroController
    {
        private $renderer;
        private $registerModel;
        
        public function __construct($renderer, $registerModel)
        {
           $this->registerModel=$registerModel;
            $this->renderer = $renderer;
        }
        
        
        public function list()
        {
            $this->renderer->render('registro');
        }
        
        public function register()
        {
            $errores = 0;
           list($name, $lastName, $email, $birthDate, $genderId, $password, $password2,$userName) =$this->getInformation();
           $emailObtenido = $this->registerModel->getUserEmail($email);
           if(!empty($emailObtenido) && $emailObtenido[0]['correo'] == $email){
                $data['emailDuplicado']="El email ya se encuentra en la bd";
               $errores ++;
           }

           $username = $this->registerModel->getUsername($userName);
           if(!empty($username) && $username[0]['nombreUsuario'] == $userName){
               $data['usernameDuplicado']="El username ya se encuentra en uso";
               $errores ++;
           }

           if( $errores == 0 && $this->verificarDatos($name,$lastName,$email, $birthDate, $genderId, $password, $password2, $userName)){
               var_dump("vamos bien");
               $this->registerModel->register($name,$lastName,$email, $birthDate, $genderId, $password,$userName);
               $data['id'] = $this->registerModel->getUserByUsername($userName);
               $this->renderer->render('validate',$data);
               exit();
           }else{
              
               var_dump("algo fallo");
               $data['error'] = true;
               $this->renderer->render('registro',$data);
           }
          
        }

        public function saveUserPhoto()
        {
            $ruta = "./public/";
            $nombre_archivo = '';
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $archivo = $_FILES["archivo"]["name"];
                $nombre = $_POST["nombre"];
                
                $extension = pathinfo($archivo, PATHINFO_EXTENSION);
                
                if (in_array($extension, array("jpg", "jpeg", "png", "gif"))) {
                    $nombre_archivo = uniqid() . "." . $extension;
                    move_uploaded_file($_FILES["archivo"]["tmp_name"], $ruta . $nombre_archivo);
                    rename($ruta . $nombre_archivo, $ruta . $nombre . "." . $extension);
                    exit();
                }
            }
            
            $archivos = scandir($ruta);
            
            echo '<img src="' . $ruta . $nombre_archivo . '" alt="' . $archivo . '"/>';
        }
        
        private function verifyPassword(mixed $password, mixed $password2)
        {
            if ($password2 != '' && $password != '') {
                
                return $password === $password2;
                
            }
            return false;
        }
        
        /**
         * @return array
         */
        public function getInformation(): array
        {
            $name = $_POST['nombre'] ?? "";
            $lastName = $_POST['apellido'] ?? "";
            $email = $_POST['email'] ?? "";
            $birthDate = $_POST['nacimiento'] ?? "";
            $genderId = $_POST['tipo'] ?? "";
            $password = $_POST['password'] ?? "";
            $password2 = $_POST['password2'] ?? "";
            $userName= $_POST['usuario'] ?? "";
            $userPhoto = $_FILES["archivo"];// esto queda pendiente para no joder tanto ahora
            if($name&&$lastName&&$email&&$birthDate&&$genderId&&$password&&$password2&& $userName){
                return array($name, $lastName, $email, $birthDate, $genderId, $password, $password2,$userName );
                
            }else{
                echo "debe cargar todos los datos";
                $this->renderer->render('registro');
                exit();
            }
      
          
        }
    
        private function verificarDatos(mixed $name, mixed $lastName, mixed $email, mixed $birthDate, mixed $genderId, mixed $password, mixed $password2, mixed $userName)
        {
            $respuesta= true;
            if(!$this->verifyPassword($password,$password2)&&filter_var($email, FILTER_VALIDATE_EMAIL)){
                $respuesta=false;
            }
            return $respuesta;
        }


    
        
    
    
    }