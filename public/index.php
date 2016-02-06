<?php

/*define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));

$url = $_GET['url'];

require_once (ROOT . DS . 'config' . DS . 'config.php');
require_once (ROOT . DS . 'library' . DS . 'Router.php');


$dir = __DIR__;
$path = substr($dir, strlen($_SERVER['DOCUMENT_ROOT']));
$link = $_SERVER['REQUEST_URI'];
$route = substr($link, strlen($path));

$router = new Router();
$response = $router->run($route);
*/

require '../vendor/autoload.php';
require_once '../config/config.php';