<?php
namespace App\Controllers;


class RegisterController
{

    public function defaultAction(){
        $twig = new \Config\Twig('registration/index.html.twig');
        $twig->render(
            array
            (
                'title' => 'Inscription'
            )
        );
    }

    public function signupAction() {
        try {
            $connexion = new \App\Models\Model\QueryBuilder('localhost','mathieuphung', 'root', 'root');
        }
        catch (\Exception $e) {
            die("Impossible de se connecter a la base de donnee");
        }
        try{
            $user = new \App\Entities\UsersEntity();
            $user->getWithId(10);
            $user->setLogin($_POST['login']);
            $user->setPassword($_POST['password']);
            $user->getAll();
            $connexion->persist($user);
            $query = "Vous etes maintenant inscrit";
        }
        catch (\Exception $e) {
            die("Un probleme est survenu lors de la requete");
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