<?php
// Fichier : index.php

// 1. Définition du chemin de base (Crucial pour trouver le .env et vendor)
define('ROOT_PATH', __DIR__ . DIRECTORY_SEPARATOR);

require_once ROOT_PATH . 'vendor/autoload.php';


// --- CHARGEMENT DU .ENV ---

use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(ROOT_PATH);
$dotenv->load(); 
// ---------------------------------------------

// Démarrage de la session (si nécessaire pour AuthController)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Exécution du Routeur
$router = new Router(); 
$router->handleRequest($_GET);