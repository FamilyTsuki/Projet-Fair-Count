<?php

namespace App\Service;

class Router
{
    public function run(): void
    {
        // Récupération de la route (ex: index.php?route=depense/creer)
        $route = $_GET['route'] ?? 'home/index';
        
        $parts = explode('/', $route);
        
        // Par défaut: HomeController
        $controllerName = !empty($parts[0]) ? ucfirst($parts[0]) . 'Controller' : 'HomeController';
        $methodName = $parts[1] ?? 'index';
        
        // Namespace complet
        $controllerClass = "App\\Controller\\" . $controllerName;
        
        if (class_exists($controllerClass)) {
            $controller = new $controllerClass();
            if (method_exists($controller, $methodName)) {
                $controller->$methodName();
            } else {
                echo "Erreur 404 : Méthode non trouvée";
            }
        } else {
            echo "Erreur 404 : Contrôleur non trouvé";
        }
    }
}