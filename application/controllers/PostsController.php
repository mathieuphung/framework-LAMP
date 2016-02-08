<?php
namespace App\Controllers;


class PostsController
{
    public function show($slug, $id, $page) {
        $twig = new \Config\Twig('posts/index.html.twig');
        $twig->render(
            array
            (
                'slug' => $slug,
                'id' => $id,
                'page' => $page
            )
        );
    }

    public function getAll() {
        $twig = new \Config\Twig('posts/index.html.twig');
        $twig->render(
            array
            (
            )
        );
    }
    
}