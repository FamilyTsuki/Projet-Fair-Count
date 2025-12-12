<?php


class PageController extends AbstractController 
{
    // --- ACCUEIL ---

   public function home() : void
    {
        $isConnected = $this->isAuthenticated();
        $username = null;

        if ($isConnected) {

        $username = $_SESSION['username'] ?? 'Utilisateur'; 
    }

        $this->render("home", [
            "pageTitle" => "Fair Count",
            "isConnected" => $isConnected, // Envoi de l'état
            "username" => $username        // Envoi du nom d'utilisateur
        ]);
    }
    public function groupe() : void
    {
        $GroupeManager = new GroupeManager();
        $isConnected = $this->isAuthenticated();
        $username = null;
        $groupes = $GroupeManager->getAllGroupe(); 
        if ($isConnected) {

        $username = $_SESSION['username'] ?? 'Utilisateur'; 
    }

        $this->render("groupe", [
            "pageTitle" => "Fair groupe",
            "isConnected" => $isConnected, // Envoi de l'état
            "username" => $username,       // Envoi du nom d'utilisateur
            "groupes" => $groupes
        ]);
    }

    // --- GESTION DES ÉQUIPES ---
    public function depance() : void
    {
        
           
        $this->render("depance", [
            
            "pageTitle" => "Les depance",
            
        ]);
        
    }

    // --- GESTION DES JOUEURS ---
  public function ranbourccemant() : void
    {
        $this->render("ranbourccemant", [

            "pageTitle" => "Les ranbourccemant",
            
        ]);
        
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
    public function unlogin() : void
    {
        $this->render("../auth/unlogin", [
        ]);
    }
   // --- ERREUR 404 ---
    public function notFound() : void
    {
        $isConnected = $this->isAuthenticated();
        $username = null;

        if ($isConnected) {

        $username = $_SESSION['username'] ?? 'Utilisateur'; 
        }
        $this->render("notFound", [
            "pageTitle" => "Page introuvable",
            "isConnected" => $isConnected,
            "username"=> $username
        ]);
    }
}