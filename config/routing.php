<?php
$router = new Library\Router($_GET['url']);

$router->get('/', 'Home#defaultAction');
$router->get('/posts', function () {
    echo 'Tous les articles';
});
$router->get('/posts/:slug-:id/:page', 'Posts#show')->with('id', '[0-9]+')->with('page', '[0-9]+')->with('slug', '([a-z\-0-9]+)');
$router->get('/posts/:id', "Posts#show");
$router->post('/posts/:id', function ($id) {
    echo 'Poster pour l\'article ' . $id . '<pre>' . print_r($_POST, true) . '</pre>';
});

$router->run();