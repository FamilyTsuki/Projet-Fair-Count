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
        $isConnected = $this->isAuthenticated();
        $username = null;

        if ($isConnected) {

        $username = $_SESSION['username'] ?? 'Utilisateur'; 
    }

        $this->render("home", [
            "pageTitle" => "Fair groupe",
            "isConnected" => $isConnected, // Envoi de l'état
            "username" => $username        // Envoi du nom d'utilisateur
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