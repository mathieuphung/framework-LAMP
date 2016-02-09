<?php
namespace App\Models\Model;

abstract class Connexion extends \PDO{
    private static $connexion = null;

    public function __construct($host, $db, $user, $password)
    {
        self::$connexion = new \PDO('mysql:host='.$host.';dbname='.$db, $user, $password);
        self::$connexion->query("SET NAMES utf-8;");
    }

    public static function getConnexion()
    {
        return self::$connexion;
    }
}