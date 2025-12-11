<?php


class PageController extends AbstractController 
{
    // --- ACCUEIL ---

    public function home() : void
    {
        
        

        $this->render("home", [
            "pageTitle" => "link count",
            
        ]);

    }

    // --- GESTION DES ÉQUIPES ---
    public function depance() : void
    {
        

        if (isset($_GET['id'])) 
        {
            $id = (int)$_GET['id'];
            
            $this->render("depance", [
                
                "pageTitle" => "Détail de la depance"
            ]);
        } 
        else
        {
        
        
        $this->render("depance", [
            
            "pageTitle" => "Les depance"
        ]);
        }
    }

    // --- GESTION DES JOUEURS ---
  public function ranbourccemant() : void
    {

        if (isset($_GET['id'])) 
        {
            $id = (int)$_GET['id'];

            $this->render("ranbourccemant", [

                "pageTitle" => "Profil du ranbourccemant"
            ]);
        } 
        else 
        {


            $this->render("ranbourccemant", [

                "pageTitle" => "Les ranbourccemant"
            ]);
        }
    }
     public function connect() : void
    {
        $this->render("connect", [
            "pageTitle" => "link count",
            
        ]);

    }
   // --- ERREUR 404 ---
    public function notFound() : void
    {
        $this->render("notFound", ["pageTitle" => "Page introuvable"]);
    }
}