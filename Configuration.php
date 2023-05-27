<?php
include_once('helpers/MySqlDatabase.php');
include_once("helpers/MustacheRender.php");
include_once('helpers/Router.php');
include_once('third-party/mustache/src/Mustache/Autoloader.php');


include_once('controller/HomeController.php');
include_once('controller/LoginController.php');
include_once('controller/ValidationController.php');
include_once('model/HomeModel.php');
include_once('model/UserModel.php');
include_once ('model/RegisterModel.php');

include_once('controller/RegistroController.php');

include_once ('controller/ReportarController.php');
include_once ('model/ReportarModel.php');

include_once ('controller/PerfilController.php');
include_once ('model/PerfilModel.php');


class Configuration {
    private $configFile = 'config/config.ini';

    public function __construct() {
    }

    public function getValidationController() {
        return new ValidationController($this->getRenderer(), new RegisterModel($this->getDatabase()));
    }

    public function getHomeController() {
        return new homeController($this->getRenderer(), new HomeModel($this->getDatabase()));
    }
    public function getRegistroController() {
        return new registroController($this->getRenderer(),new RegisterModel($this->getDatabase()));
    }

    public function getLoginController(){
        return new loginController($this->getRenderer(), new UserModel($this->getDatabase()));
    }

    public function getReportarController(){
        return new reportarController($this->getRenderer(), new ReportarModel($this->getDatabase()));
    }

    public function getPerfilController(){
        return new perfilController($this->getRenderer(), new PerfilModel($this->getDatabase()));
    }

    private function getArrayConfig() {
        return parse_ini_file($this->configFile);
    }

    private function getRenderer() {
        return new MustacheRender('view/partial');
    }

    public function getDatabase() {
        $config = $this->getArrayConfig();
        return new MySqlDatabase(
            $config['SERVER'],
            $config['USERNAME'],
            $config['PASSWORD'],
            $config['DATABASE'],
            $config['PORT']);
    }

    public function getRouter() {
        return new Router(
            $this,
            "getHomeController",
            "list");
    }
}