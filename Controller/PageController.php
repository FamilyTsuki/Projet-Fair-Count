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
        
        $userManager = new UsersManager();

        $users = $userManager->getAllUsers(); 
        if (isset($_GET['id'])) 
        {
            $id = (int)$_GET['id'];
            $user = $userManager->getUserById($id); 
            $this->render("depance", [
                
                "pageTitle" => "Détail de la depance",
                "users" => $users,
                "user"=> $user
            ]);
        } 
        else
        {
        
        
        $this->render("depance", [
            
            "pageTitle" => "Les depance",
            "users" => $users
        ]);
        }
    }

    // --- GESTION DES JOUEURS ---
  public function ranbourccemant() : void
    {
        $userManager = new UsersManager();

        $users = $userManager->getAllUsers();
        if (isset($_GET['id'])) 
        {
            $id = (int)$_GET['id'];
            $user = $userManager->getUserById($id); 
            $this->render("ranbourccemant", [

                "pageTitle" => "Profil du ranbourccemant",
                "users"=> $users,
                "user"=> $user
            ]);
        } 
        else 
        {


            $this->render("ranbourccemant", [

                "pageTitle" => "Les ranbourccemant",
                "users"=> $users
            ]);
        }
    }
     public function connect() : void
    {
        $this->render("../auth/login", [
            "pageTitle" => "link count",    
            
        ]);

    }
    public function creat() : void
    {
        $this->render("../auth/register", [
            "pageTitle" => "link count",    
            
        ]);

    }
   // --- ERREUR 404 ---
    public function notFound() : void
    {
        $this->render("notFound", ["pageTitle" => "Page introuvable"]);
    }
}