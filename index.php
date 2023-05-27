<?php
include_once('Configuration.php');
include_once('helpers/Session.php');

Session::initializeSession();

$configuration = new Configuration();
$router = $configuration->getRouter();

$module = $_GET['module'] ?? 'home';
$method = $_GET['action'] ?? 'list';
//Header::debug($module);
$router->route($module, $method );
