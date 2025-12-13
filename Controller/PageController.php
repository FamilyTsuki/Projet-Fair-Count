<?php


class PageController extends AbstractController 
{
    // --- ACCUEIL ---

   public function home() : void
    {
        $isConnected = $this->isAuthenticated();
        $username = null;
        $user = null;
        $tune = null;
        if ($isConnected) {

        $username = $_SESSION['username'] ?? 'Utilisateur'; 
        $user = $_SESSION['user'];
        $tune = $_SESSION['tune'];

    }

        $this->render("home", [
            "pageTitle" => "Fair Count",
            "isConnected" => $isConnected, // Envoi de l'état
            "username" => $username,        // Envoi du nom d'utilisateur
            "user" => $user,
            "tune"=> $tune,

        ]);
    }
    public function groupe() : void
    {
        $GroupeManager = new GroupeManager();
        $isConnected = $this->isAuthenticated();
        $username = null;
        $tune = null;
        $groupes = $GroupeManager->getAllGroupe($_SESSION['user_id']); 
        if ($isConnected) {

        $username = $_SESSION['username'] ?? 'Utilisateur'; 
        $tune = $_SESSION['tune'];
    }

        $this->render("groupe", [
            "pageTitle" => "Fair groupe",
            "isConnected" => $isConnected, // Envoi de l'état
            "username" => $username,       // Envoi du nom d'utilisateur
            "groupes" => $groupes,
            "user" => $_SESSION['user'],
            'tune' => $tune
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
    public function created_group() : void
    {
        $isConnected = $this->isAuthenticated();
        $username = null;
        $tune = null;
        if ($isConnected) {

        $username = $_SESSION['username'] ?? 'Utilisateur'; 
        $tune = $_SESSION['tune'];
        }
        $this->render("../partials/created_group", [
            "pageTitle" => "link group",    
            "isConnected" => $isConnected, // Envoi de l'état
            "username" => $username,        // Envoi du nom d'utilisateur
            "user" => $_SESSION['user'],
            'tune' => $tune
            
        ]);

    }
    public function join_group() : void
    {
        $isConnected = $this->isAuthenticated();
        $username = null;
        $tune = null;

        if ($isConnected) {

        $username = $_SESSION['username'] ?? 'Utilisateur'; 
        $tune = $_SESSION['tune'];
        }
        $this->render("../partials/join_group", [
            "pageTitle" => "link group",    
            "isConnected" => $isConnected, // Envoi de l'état
            "username" => $username,        // Envoi du nom d'utilisateur
            "user" => $_SESSION['user'],
            'tune' => $tune
            
        ]);


    }
    public function compt() : void
    {
        $isConnected = $this->isAuthenticated();
        $username = null;
        $groupmanager = new GroupeManager();
        $tune = null;

        if ($isConnected && isset($_GET['code'])) 
        {
            $username = $_SESSION['username'] ?? 'Utilisateur'; 
            $tune = $_SESSION['tune'];
            $code = $_GET['code'];
            $group = $groupmanager->getGroupBycode($code);
            

            $this->render("../partials/compt", [
                "isConnected" => $isConnected, // Envoi de l'état
                "username" => $username,        // Envoi du nom d'utilisateur
                "group" => $group,
                "user" => $_SESSION['user'],
                'tune' => $tune
            ]);
        } 
        

    }
   // --- ERREUR 404 ---
    public function notFound() : void
    {
        $isConnected = $this->isAuthenticated();
        $username = null;
        $tune = null;
        if ($isConnected) {

        $username = $_SESSION['username'] ?? 'Utilisateur'; 
        $tune = $_SESSION['tune'];
        }
        $this->render("notFound", [
            "pageTitle" => "Page introuvable",
            "isConnected" => $isConnected,
            "username"=> $username,
            "user" => $_SESSION['user'],
            'tune' => $tune
        ]);
    }
}