<?php
// Fichier : index.php

// 1. Définition du chemin de base (Crucial pour trouver le .env et vendor)
define('ROOT_PATH', __DIR__ . DIRECTORY_SEPARATOR);

// 2. Chargement de l'autoloader de Composer
require_once ROOT_PATH . 'vendor/autoload.php';

// 3. Importation des classes nécessaires (si vous avez réintroduit les namespaces)
// use Dotenv\Dotenv; 
// use Router; // Si vous êtes dans le namespace global

// --- ÉTAPE CRUCIALE : CHARGEMENT DU .ENV ---
// Assurez-vous que Dotenv est bien chargé par votre classmap.
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(ROOT_PATH);
$dotenv->load(); 
// ---------------------------------------------

// 4. Démarrage de la session (si nécessaire pour AuthController)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 5. Exécution du Routeur
$router = new Router(); 
$router->handleRequest($_GET);