<?php

// Inclusión de Controladores
include_once('controller/RegistroController.php');
include_once('controller/ReportarController.php');
include_once('controller/PerfilController.php');
include_once('controller/HomeController.php');
include_once('controller/LoginController.php');
include_once('controller/ActivationController.php');
include_once('controller/PreguntaController.php');
include_once('controller/PartidaController.php');

// Inclusión de Helpers
include_once('helpers/MySqlDatabase.php');
include_once("helpers/MustacheRender.php");
include_once('helpers/Router.php');
include_once "helpers/Mailer.php";
include_once "helpers/QRGenerator.php";
require_once "helpers/Logger.php";

// Inclusión de Models
include_once('model/HomeModel.php');
include_once('model/UserModel.php');
include_once('model/RegisterModel.php');
include_once('model/ReportarModel.php');
include_once('model/PerfilModel.php');
include_once('model/CategoriaModel.php');
include_once('model/PreguntaModel.php');
include_once('model/OpcionModel.php');
include_once('model/PartidaModel.php');

//Inclusión de Servicios
require_once 'Services/PreguntaServices.php';

// Inclusión de Bibliotecas de Terceros
include_once('third-party/mustache/src/Mustache/Autoloader.php');

class Configuration
{
    private $configFile = 'config/config.ini';
    private static $instance;

    private function __construct()
    {
        Logger::error("LLAMANDO AL CONSTRUCTOR DE LA CONFIGURACION");
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getPreguntaController()
    {
        return new PreguntaController($this->getRenderer(), [
            'pregunta' => new PreguntaModel($this->getDatabase()),
            'respuesta' => new OpcionModel($this->getDatabase()),
            'categoria' => new CategoriaModel($this->getDatabase())
        ]);
    }

    public function getPartidaController()
    {
        return new PartidaController($this->getRenderer(),
            new PartidaModel($this->getDatabase(),
                new Services\PreguntaServices($this->getDatabase()))
        );
    }

    public function getActivationController()
    {
        return new ActivationController($this->getRenderer(),
            new RegisterModel($this->getDatabase()));
    }

    public function getHomeController()
    {
        return new homeController($this->getRenderer(), new HomeModel($this->getDatabase()));
    }

    public function getRegistroController()
    {
        return new registroController($this->getRenderer(), $this->getMailRenderer(), new RegisterModel($this->getDatabase()),
            $this->getMailer());
    }

    public function getLoginController()
    {
        return new loginController($this->getRenderer(), new UserModel($this->getDatabase()));
    }

    public function getReportarController()
    {
        return new reportarController($this->getRenderer(), new ReportarModel($this->getDatabase()));
    }

    public function getPerfilController()
    {
        return new perfilController($this->getRenderer(), new UserModel($this->getDatabase()), new PerfilModel($this->getDatabase()), $this->getQRGenerator());
    }
    public function getRankingController(){
        include_once ('controller/RankingController.php');
        include_once ('model/RankingModel.php');
        return new rankingController($this->getRenderer(), new RankingModel($this->getDatabase()));
    }



    private function getArrayConfig()
    {
        return parse_ini_file($this->configFile);
    }

    private function getRenderer()
    {
        return new MustacheRender('view/partial');
    }

    public function getDatabase()
    {
        $config = $this->getArrayConfig();
        return new MySqlDatabase(
            $config['SERVER'],
            $config['USERNAME'],
            $config['PASSWORD'],
            $config['DATABASE'],
            $config['PORT']);
    }

    public function getRouter()
    {
        return new Router(
            $this,
            "getHomeController",
            "list");
    }

    public function getMailer()
    {
        return new Mailer();
    }

    private function getMailRenderer()
    {
        return new MustacheRender('public/template');
    }

    public function getQRGenerator()
    {
        return new QRGenerator('public/qr');
    }
}
