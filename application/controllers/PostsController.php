<?php
namespace App\Controllers;


class PostsController
{

    public function show($slug, $id, $page) {
        echo "Je suis le post $id Je suis en page $page" ;
    }
    
}