<?php
include_once('Configuration.php');
include_once('helpers/Session.php');

Session::initializeSession();

/*$configuration = new Configuration();*/
$router = Configuration::getInstance()->getRouter();

$module = $_GET['module'] ?? 'inicio';
$method = $_GET['action'] ?? 'list';

/*$controladoresValidosSINLogeo = [
    'home',
    'login',
    'registro',
    'activation',
    'perfil',
    'ranking',

];
$controladoresINVALIDOSLogeado = [
    'registro',
    'activation',
    //'home',
];

if (!Session::isLogged() && !in_array($module, $controladoresValidosSINLogeo)){
        $module = 'home';
}
if (Session::isLogged() && in_array($module, $controladoresINVALIDOSLogeado)){
        $module = 'home';
      //$module = 'juego';
}*/


$router->route($module, $method);
?>
