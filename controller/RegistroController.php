<?php

class RegistroController
{
    private mixed $renderer;
    private mixed $registerModel;
    private mixed $emailSender;
    private mixed $renderMail;


    public function __construct($renderer, $renderMail, $registerModel, $emailSender)
    {
        $this->registerModel = $registerModel;
        $this->renderer = $renderer;
        $this->emailSender = $emailSender;
        $this->renderMail = $renderMail;
    }


    public function list(): void
    {
        if (!Session::get("logged")) {
            $data['mapa'] = true;
            $data['registroJS'] = true;
            $this->renderer->render('registro', $data);
            exit();
        } else {
            Header::redirect("/");
        }
    }

    public function register(): void
    {
        $errores = 0;
        list($name, $lastName, $email, $birthDate, $genderId, $password, $password2, $userName, $Coordenadas, $userPhoto) = $this->getDatos();
        $emailObtenido = $this->registerModel->getUserEmail($email);
        if (!empty($emailObtenido) && $emailObtenido['correo'] == $email) {
            $data['emailDuplicado'] = "El email ya se encuentra en la bd";
            $errores++;
        }

        $username = $this->registerModel->getUsername($userName);
        if (!empty($username) && $username[0]['nombreUsuario'] == $userName) {
            $data['usernameDuplicado'] = "El username ya se encuentra en uso";
            $errores++;
        }
        $verficar = $this->verificarDatos($name, $lastName, $email, $birthDate, $genderId, $password, $password2, $userName, $Coordenadas);

        if ($errores == 0 && $verficar) {
            $namePhoto = $this->saveUserPhoto();

            $this->registerModel->register($name, $lastName, $email, $birthDate, $genderId, $password, $userName, $namePhoto, $Coordenadas);
            $registro = $this->registerModel->getUserByUsername($userName);
            $data['id'] = $registro['id'];
            $data['username'] = $registro['nombreUsuario'];

            $html = $this->renderMail->generateTemplatedStringForEmail('templanteMail', $data);
            $this->emailSender->sendEmail($email, 'Confirmacion de Registro', $html);
            $this->renderer->render('activacion', $data);
            exit();
        } else {
            $data['error'] = true;
            $this->renderer->render('registro', $data);
            exit();
        }
    }

    public function saveUserPhoto(): string
    {
        $ruta = "./public/img/";
        $nombre = '';
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $archivo = $_FILES["archivo"]["name"];
            $nombre = $_POST["usuario"];
            $extension = pathinfo($archivo, PATHINFO_EXTENSION);
            if (in_array($extension, array("jpg", "jpeg", "png", "gif"))) {
                $nombre_archivo = uniqid() . "." . $extension;
                move_uploaded_file($_FILES["archivo"]["tmp_name"], $ruta . $nombre_archivo);
                rename($ruta . $nombre_archivo, $ruta . $nombre . "." . $extension);
            }
        }
        return $nombre . '.' . $extension;

    }

    private function verifyPassword(mixed $password, mixed $password2): bool
    {
        if ($password2 != '' && $password != '') {
            return $password === $password2;
        }
        return false;
    }

    public function getDatos()
    {
        if (
            !empty($_POST['nombre']) &&
            !empty($_POST['apellido']) &&
            !empty($_POST['email']) &&
            !empty($_POST['nacimiento']) &&
            !empty($_POST['tipo']) &&
            !empty($_POST['password']) &&
            !empty($_POST['password2']) &&
            !empty($_POST['usuario']) &&
            !empty($_POST['coordenadas']) &&
            isset($_FILES['archivo']) &&
            $_FILES['archivo']['error'] === 0
        ) {
            $name = $_POST['nombre'];
            $lastName = $_POST['apellido'];
            $email = $_POST['email'];
            $birthDate = $_POST['nacimiento'];
            $genderId = $_POST['tipo'];
            $password = $_POST['password'];
            $password2 = $_POST['password2'];
            $userName = $_POST['usuario'];
            $coordenadas = $_POST['coordenadas'];
            $userPhoto = $_FILES["archivo"];
            return array($name, $lastName, $email, $birthDate, $genderId, $password, $password2, $userName, $coordenadas, $userPhoto);

        } else {
            echo "debe cargar todos los datos";
            $this->renderer->render('registro');
            exit();
        }
    }

    private function verificarDatos(mixed $firstName, mixed $lastName, mixed $email, mixed $birthDate, mixed $genderId, mixed $password, mixed $password2, mixed $userName, mixed $coordenadas): bool
    {
        $respuesta = true;
        if (!$this->verifyPassword($password, $password2) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $respuesta = false;
        }
        return $respuesta;
    }

    public function enviarEmail($id): array
    {
        $usuario = $this->registerModel->getUserByID($id);
        $data = [];
        if (empty($usuario)) {
            $data['message'] = 'El usuario que intenta activar no existe';
        } else {
            $html = $this->renderMail->generateTemplatedStringForEmail('templanteMail', [
                'id' => $usuario['id'],
                'usarname' => $usuario['nombreUsuario']
            ]);
            Session::set('momentoEnvio', time());
            $this->emailSender->sendEmail($usuario['correo'], 'Confirmacion de Registro', $html);
            $data['message'] = 'Se ha reenviado el correo de activación';
        }
        return $data;
    }

}
?>