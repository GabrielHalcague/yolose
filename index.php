<?php
include_once('Configuration.php');
include_once('helpers/Session.php');

Session::initializeSession();
$config = new Configuration();
$router = $config->getRouter();

$module = $_GET['module'] ?? 'inicio';
$method = $_GET['action'] ?? 'list';


$controladoresValios = [
    'home',
    'perfil',
    'tienda',
    'editor',
    'administrador',
    'partida',
    'tarjeta',
    'agregarPregunta',
    'verReporte',
    'verPregunta'
];

if(empty(Session::get('logged'))&& in_array($module, $controladoresValios)){
   Header::redirect("/");
}

$router->route($module, $method);
?>