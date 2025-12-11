<?php

namespace App\Controller;

class HomeController extends AbstractController
{
    public function index(): void
    {
        $this->render('home', ['title' => 'Accueil - Fair Count']);
    }
}