<?php


use PDO;

abstract class AbstractManager
{
    

    public function __construct()
    {
        $host = $_ENV['DB_HOST'];
        $dbname = $_ENV['DB_NAME'];
        $user = $_ENV['DB_USER'];
        $pass = $_ENV['DB_PASS'];
        $port = $_ENV['DB_PORT'];
        $connexionString = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8";

        $user = "votre_username";
        $password = "votre_password";

        $db = new PDO(
            $connexionString,
            $user,
            $password
);


    }
    
}
