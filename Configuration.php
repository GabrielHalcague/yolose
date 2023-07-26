<?php

include_once('controller/HomeController.php');
include_once('controller/CoreoArgentinoController.php');


// Inclusión de Helpers
//include_once('helpers/MySqlDatabase.php');
include_once("helpers/MustacheRender.php");
include_once('helpers/Router.php');
require_once "helpers/Logger.php";
require_once "helpers/PDFGenerator.php";
// Inclusión de Models
include_once('model/HomeModel.php');
include_once('model/CorreoArgentinoModel.php');


// Inclusión de Bibliotecas de Terceros
include_once('third-party/mustache/src/Mustache/Autoloader.php');

class Configuration
{
    private mixed $configFile = 'config/config.ini';

    public function __construct(){
    }

    public function getHomeController(): HomeController
    {
        return new homeController($this->getRenderer());
    }
    public function getCorreoArgentinoController(): CoreoArgentinoController
    {
        return new coreoArgentinoController($this->getRenderer(), $this->getPDF());
    }


    private function getArrayConfig(): false|array
    {
        return parse_ini_file($this->configFile);
    }

    private function getRenderer(): MustacheRender
    {
        return new MustacheRender('view/partial');
    }

    public function getDatabase(): MySqlDatabase
    {
        $config = $this->getArrayConfig();
        return new MySqlDatabase(
            $config['SERVER'],
            $config['USERNAME'],
            $config['PASSWORD'],
            $config['DATABASE']
        );
    }

    public function getRouter(): Router
    {
        return new Router(
            $this,
            "getHomeController",
            "list");
    }

    public function getMailer(): Mailer
    {
        return new Mailer();
    }

    private function getMailRenderer(): MustacheRender
    {
        return new MustacheRender('public/template');
    }


    private function getPDF(): PDFGenerator
    {
        return new PDFGenerator();
    }

    private function getPDFRender(): MustacheRender
    {
        return new MustacheRender("public/template");
    }
}
