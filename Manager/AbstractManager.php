<?php


use PDO;

abstract class AbstractManager
{
    protected PDO $pdo;

    public function __construct()
    {
        $host = "host de la base, généralement localhost";
$port = "3306";
$dbname = "nomdelabase";
$connexionString = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8";

$user = "votre_username";
$password = "votre_password";

$db = new PDO(
    $connexionString,
    $user,
    $password
);


    }
    
    // ...
}