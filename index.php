<?php

// Le require est direct, il n'y a pas de dossier à remonter
require_once __DIR__ . '/vendor/autoload.php';

use App\Service\Router;
use Dotenv\Dotenv;

// Le chemin .env est maintenant le dossier courant (la racine)
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$router = new Router();
$router->run();