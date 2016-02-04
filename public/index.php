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

$router = new Library\Router($_GET['url']);

$router->get('/', function(){ echo 'Homepage'; });
$router->get('/posts', function(){ echo 'Tous les articles'; });
$router->get('/posts/:slug-:id/:page', 'Posts#show')->with('id', '[0-9]+')->with('page', '[0-9]+')->with('slug', '([a-z\-0-9]+)');
$router->get('/posts/:id', "Posts#show");
$router->post('/posts/:id', function($id){ echo 'Poster pour l\'article ' . $id . '<pre>' . print_r($_POST, true) . '</pre>'; });

$router->run();