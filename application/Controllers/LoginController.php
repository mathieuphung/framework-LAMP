<?php
/**
 * Created by PhpStorm.
 * User: alexis
 * Date: 10/02/2016
 * Time: 01:18
 */

namespace App\Controllers;


class LoginController
{
    public function defaultAction(){
        $twig = new \Config\Twig('login/index.html.twig');
        $twig->render(
            array
            (
                'title' => 'Connexion'
            )
        );
    }

    public function loginAction() {
        try {
            $connexion = new \App\Models\Model\QueryBuilder('localhost','mathieuphung', 'mathieuphung', 'opLgqSuP');
        }
        catch (\Exception $e) {
            die("Impossible de se connecter a la base de donnee");
        }
        $response = $connexion->select('*','users', null, null, ['login', 'password'], [$_POST['login'], $_POST['password']]);
        if(!empty($response)) {
            \App\Models\Model\Log::access();
            $query = "Vous êtes conecté";
        }
        else {
            \App\Models\Model\Log::error();
            die("Requete invalide");
        }

        $twig = new \Config\Twig('registration/index.html.twig');
        $twig->render(
            array
            (
                'title' => 'Inscription',
                'query' => $query
            )
        );
    }
}