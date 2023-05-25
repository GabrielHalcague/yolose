<?php
include_once('helpers/MySqlDatabase.php');
include_once("helpers/MustacheRender.php");
include_once('helpers/Router.php');
include_once('third-party/mustache/src/Mustache/Autoloader.php');



include_once('controller/HomeController.php');
include_once('model/HomeModel.php');

include_once('controller/RegistroController.php');

include_once ('controller/ReportarController.php');
include_once ('model/ReportarModel.php');


class Configuration {
    private $configFile = 'config/config.ini';

    public function __construct() {
    }



    public function getHomeController() {
        return new homeController($this->getRenderer(), new HomeModel($this->getDatabase()));
    }
    public function getRegistroController() {
        return new registroController($this->getRenderer());
    }

    public function getReportarController(){
        return new reportarController($this->getRenderer(), new ReportarModel($this->getDatabase()));
    }


    public function getCerrarSeccionController(){
        session_start();
        unset($_SESSION["usuario"]);
        session_destroy();
       // header("location:index.php");
        //exit();
        return new homeController($this->getRenderer(), new HomeModel($this->getDatabase()));
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