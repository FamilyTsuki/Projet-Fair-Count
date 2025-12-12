<?php



abstract class AbstractController
{
    protected function render(string $template, array $data) : void
    {
        extract($data);
        require "templates/partials/_nav.phtml";
        require "templates/layout.phtml";
        
    }

    protected function redirect(string $route) : void
    {
        header("Location: $route");
    }
    protected function isAuthenticated(): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['user_id']);
    }
}