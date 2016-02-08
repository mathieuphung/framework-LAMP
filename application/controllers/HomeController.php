<?php
namespace App\Controllers;


class HomeController
{
    public function defaultAction()
    {
        $twig = new \Config\Twig('home/index.html.twig');
        $twig->render(
            array
            (
                'title' => 'Homepage'
            )
        );
    }
}