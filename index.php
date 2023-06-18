<?php
include_once('Configuration.php');
include_once('helpers/Session.php');

Session::initializeSession();

/*$configuration = new Configuration();*/
$router = Configuration::getInstance()->getRouter();

$module = $_GET['module'] ?? 'inicio';
$method = $_GET['action'] ?? 'list';


$controladoresValios = [
    'home',
    'perfil',
    'tienda',
    'editor',
    'administrador',
    'partida',
    'tarjeta'
];

if(empty(Session::get('logged'))&& in_array($module, $controladoresValios)){
    $module = 'inicio';
    $method = 'list';
}

$router->route($module, $method);
?>
