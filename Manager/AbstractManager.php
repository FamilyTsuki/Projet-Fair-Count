<?php


use PDO;

abstract class AbstractManager
{
    protected PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection(); 
    }
    
    // ...
}