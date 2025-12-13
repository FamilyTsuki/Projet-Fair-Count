<?php

class AuthController extends AbstractController
{

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
                
                if ($manager->register($email, $password, $username)) {
                    
                    $this->redirect('index.php?route=connect');
                    return;
                } else {
                    $error = "Cet email est déjà utilisé ou une erreur est survenue.";
                }
            }
        }

        $this->render('../auth/register', ['error' => $error]);
    }

    public function login(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $error = null;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $password = filter_input(INPUT_POST, 'password');

            if ($email && $password) {
                $manager = new UsersManager();
                
                $user = $manager->login($email, $password);
                
                if ($user) {
                    $_SESSION['user_id'] = $user->getId();
                    $_SESSION['username'] = $user->getUsername();
                    $_SESSION['user'] = $user;
                    $_SESSION['tune'] = $user->getTune();
                    
                    $this->redirect('index.php');
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

    public function unlogin(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        session_unset();
        session_destroy();
        
        $this->redirect('index.php');
    }
}