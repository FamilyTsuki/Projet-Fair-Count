<?php

namespace App\Controller;

abstract class AbstractController
{
    /**
     * Affiche un template
     * @param string $view Chemin vers le template (ex: 'home/index')
     * @param array $data Données à passer à la vue
     */
    protected function render(string $view, array $data = []): void
    {
        extract($data);
        
        // Démarre la bufferisation de sortie
        ob_start();
        require_once __DIR__ . '/../../templates/' . $view . '.php';
        $content = ob_get_clean();
        
        // Inclut le layout principal
        require_once __DIR__ . '/../../templates/layout/base.php';
    }

    protected function redirect(string $url): void
    {
        header("Location: $url");
        exit;
    }
}