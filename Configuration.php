<?php

// Inclusión de Controladores
include_once('controller/RegistroController.php');
include_once('controller/ReportarController.php');
include_once('controller/PerfilController.php');
include_once('controller/HomeController.php');
include_once('controller/InicioController.php');
include_once('controller/LoginController.php');
include_once('controller/ActivationController.php');
include_once('controller/PreguntaController.php');
include_once('controller/PartidaController.php');
include_once('controller/EditorController.php');
include_once('controller/AdministradorController.php');
include_once('controller/TiendaController.php');
include_once('controller/RankingController.php');
include_once('controller/CreditosController.php');
include_once('controller/TutorialController.php');

// Inclusión de Helpers
include_once('helpers/MySqlDatabase.php');
include_once("helpers/MustacheRender.php");
include_once('helpers/Router.php');
include_once "helpers/Mailer.php";
include_once "helpers/QRGenerator.php";
require_once "helpers/Logger.php";
require_once "helpers/PDFGenerator.php";


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
include_once('model/EditorModel.php');
include_once('model/TiendaModel.php');
include_once('model/AdministradorModel.php');
include_once('model/RankingModel.php');

//Inclusión de Servicios
require_once 'Services/PreguntaServices.php';

// Inclusión de Bibliotecas de Terceros
include_once('third-party/mustache/src/Mustache/Autoloader.php');

class Configuration
{
    private mixed $configFile = 'config/config.ini';

    public function __construct(){
    }

    public function getAdministradorController(): AdministradorController
    {
        return new administradorController($this->getRenderer(), new AdministradorModel($this->getDatabase()), $this->getPDF());
    }

    public function getTiendaController(): TiendaController
    {
        return new TiendaController($this->getRenderer(), [
            'tiendaModel' => new TiendaModel($this->getDatabase()),
            'pdf' => $this->getPDF(),
            'pdfRender' => $this->getPDFRender()
        ]);
    }

    public function getEditorController(): EditorController
    {
        return new EditorController($this->getRenderer(), [
            'editorModel' => new EditorModel($this->getDatabase())
        ]);
    }

    public function getPreguntaController(): PreguntaController
    {
        return new PreguntaController($this->getRenderer(), [
            'pregunta' => new PreguntaModel($this->getDatabase()),
            'respuesta' => new OpcionModel($this->getDatabase()),
            'categoria' => new CategoriaModel($this->getDatabase())
        ]);
    }

    public function getPartidaController(): PartidaController
    {
        return new PartidaController($this->getRenderer(),
            new PartidaModel($this->getDatabase(),
                new Services\PreguntaServices($this->getDatabase()))
        );
    }

    public function getActivationController(): ActivationController
    {
        return new ActivationController($this->getRenderer(),
            new RegisterModel($this->getDatabase()));
    }

    public function getInicioController(): InicioController
    {
        return new InicioController($this->getRenderer());
    }

    public function getHomeController(): HomeController
    {
        return new homeController($this->getRenderer());
    }

    public function getRegistroController(): registroController
    {
        return new registroController($this->getRenderer(), $this->getMailRenderer(), new RegisterModel($this->getDatabase()),
            $this->getMailer());
    }

    public function getLoginController(): LoginController
    {
        return new loginController($this->getRenderer(), new UserModel($this->getDatabase()));
    }

    public function getReportarController(): reportarController
    {
        return new reportarController($this->getRenderer(), new ReportarModel($this->getDatabase()));
    }

    public function getPerfilController(): perfilController
    {
        return new perfilController($this->getRenderer(), new UserModel($this->getDatabase()), new PerfilModel($this->getDatabase()), $this->getQRGenerator());
    }

    public function getRankingController(): rankingController
    {
        return new rankingController($this->getRenderer(), new RankingModel($this->getDatabase()));
    }

    public function getCreditosController(): CreditosController
    {
        return new CreditosController($this->getRenderer());
    }

    public function getTutorialController(): TutorialController
    {
        return new TutorialController($this->getRenderer());
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
            "getInicioController",
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

    public function getQRGenerator(): QRGenerator
    {
        return new QRGenerator('public/qr');
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
