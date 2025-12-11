<?php

namespace App\Manager;

use App\Service\Database;
use PDO;

abstract class AbstractManager
{
    protected PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }
    
    // Méthodes génériques possibles ici (findAll, findById...)
}