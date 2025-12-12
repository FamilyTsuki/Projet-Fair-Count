<?php
// Fichier : Controller/AuthController.php

// AUCUN NAMESPACE (Selon votre architecture globale)

// Assurez-vous d'avoir bien User.php et UsersManager.php
// Les classes doivent être chargées via le classmap de Composer.

class AuthController extends AbstractController
{
    /**
     * Affiche le formulaire d'inscription ou gère la soumission
     */
    public function register(): void
    {
        $error = null;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $password = filter_input(INPUT_POST, 'password');
            $username = filter_input(INPUT_POST, 'username');
            
            // Validation simple
            if (!$email || !$password || !$username) {
                $error = "Veuillez remplir tous les champs correctement.";
            } elseif (strlen($password) < 6) {
                $error = "Le mot de passe doit contenir au moins 6 caractères.";
            } else {
                
                $manager = new UsersManager();
                
                // Tente d'inscrire l'utilisateur (le Manager gère le hachage)
                if ($manager->register($email, $password, $username)) {
                    
                    $this->redirect('index.php?route=connect'); // Redirection vers la page de connexion
                    return;
                } else {
                    $error = "Cet email est déjà utilisé ou une erreur est survenue.";
                }
            }
        }

        $this->render('../auth/register', ['error' => $error]);
    }

    /**
     * Affiche le formulaire de connexion ou gère la soumission
     */
    public function login(): void
    {
        // Démarrer la session si ce n'est pas déjà fait (souvent fait dans index.php)
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $error = null;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $password = filter_input(INPUT_POST, 'password');

            if ($email && $password) {
                $manager = new UsersManager();
                
                // Tente de connecter l'utilisateur (le Manager gère la vérification du hash)
                $user = $manager->login($email, $password);
                
                if ($user) {
                    // Connexion réussie : Stocker les informations minimales en session
                    $_SESSION['user_id'] = $user->getId();
                    $_SESSION['username'] = $user->getUsername();
                    
                    $this->redirect('index.php'); // Redirection vers l'accueil
                    return;
                } else {
                    $error = "Identifiants invalides.";
                }
            } else {
                 $error = "Veuillez entrer votre email et mot de passe.";
            }
        }
        
        $this->render('../auth/login', ['error' => $error]);
    }

    /**
     * Déconnecte l'utilisateur
     */
    public function logout(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        session_unset();
        session_destroy();
        
        $this->redirect('index.php');
    }
}