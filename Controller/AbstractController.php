<?php

namespace App\Controller;

abstract class AbstractController
{
    protected function render(string $template, array $data) : void
    {
        extract($data);

        require "templates/layout.phtml";
    

    }

    protected function redirect(string $route) : void
    {
        header("Location: $route");
    }
}