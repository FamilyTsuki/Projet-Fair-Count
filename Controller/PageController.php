<?php

class PageController extends AbstractController 
{
    // --- ACCUEIL ---

    public function home() : void
    {
        $teamManager = new TeamManager();
        $playerManager = new PlayerManager();
        $gameManager = new GameManager();

        $teams = $teamManager->getAllTeam(); 
        $players = $playerManager->getAllPlayers();
        $games = $gameManager->getAllGames();
        

        $this->render("home", [
            "pageTitle" => "The League",
            "teams" => $teams,
            "players" => $players,
            
            "matches" => $games
        ]);

    }

    // --- GESTION DES ÉQUIPES ---
    public function team() : void
    {
        $teamManager = new TeamManager();

        if (isset($_GET['id'])) 
        {
            $id = (int)$_GET['id'];
            $team = $teamManager->getTeamById($id);

            $this->render("team", [
                "team" => $team,
                "pageTitle" => "Détail de la team"
            ]);
        } 
        else
        {
        $teams = $teamManager->getAllTeam();
        
        $this->render("team", [
            "teams" => $teams,
            "pageTitle" => "Les teams"
        ]);
        }
    }

    // --- GESTION DES JOUEURS ---
  public function player() : void
    {
        $playerManager = new PlayerManager();
        $teamManager = new TeamManager();
        $gameManager = new GameManager();
        if (isset($_GET['id'])) 
        {
            $id = (int)$_GET['id'];
            $player = $playerManager->getPlayerById($id);
            
            $perfManager = new Player_PerformanceManager();
            $stats = $perfManager->getStatsByPlayerId($id);

            $teams = $teamManager->getAllTeam(); 
            $games = $gameManager->getAllGames();
            $this->render("player", [
                "player" => $player,
                "stats" => $stats,
                "teams" => $teams,
                "games" => $games,
                "pageTitle" => "Profil du joueur"
            ]);
        } 
        else 
        {
            $players = $playerManager->getAllPlayers();
            $teams = $teamManager->getAllTeam(); 

            $this->render("player", [
                "players" => $players,
                "teams" => $teams,
                "pageTitle" => "Les players"
            ]);
        }
    }

    // --- GESTION DES MATCHS ---
    public function match() : void
    {
        $gameManager = new GameManager();
        $perfManager = new Player_PerformanceManager();
        $teamManager = new TeamManager();
        
        $teams = $teamManager->getAllTeam(); 

        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            
            $game = $gameManager->getGameById($id); 
            $stats = $perfManager->getStatsByGameId($id); 

            $this->render("match", [
                "match" => $game,
                "stats" => $stats,
                "pageTitle" => "Détails du match",
                "teams" => $teams,
            ]);
        }
        else 
        {
            $games = $gameManager->getAllGames();
            $this->render("match", [
                "matches" => $games,
                "teams" => $teams,
                "pageTitle" => "Les matchs"
            ]);
        }
    }
    // --- ERREUR 404 ---
    public function notFound() : void
    {
        $this->render("notFound", ["pageTitle" => "Page introuvable"]);
    }
}