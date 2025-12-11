<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Service\Router;
use Dotenv\Dotenv;

// Chargement des variables d'environnement
$dotenv = Dotenv::createImmutable(__DIR__ . '/..'); 
$dotenv->load();

// Lancement du routeur
$router = new Router();
$router->run();