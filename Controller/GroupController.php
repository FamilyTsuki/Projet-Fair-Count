<?php
class GroupeController extends AbstractController
{
    public function create(): void
    {
        // On suppose que l'utilisateur doit être connecté pour créer un groupe
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('index.php?route=connect'); 
            return;
        }

        $error = null;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $code = filter_input(INPUT_POST, 'code', FILTER_SANITIZE_STRING);
            
            // On peut ajouter une validation pour le nom et le code ici
            if (!$name || !$code || strlen($code) < 4) {
                 $error = "Le nom et le code doivent être valides (code min 4 caractères).";
            } else {
                // 1. Instanciation des Managers
                $groupeManager = new GroupeManager();
                $participantManager = new Groupe_participantManager();
                
                // Le budget par défaut est 0 lors de la création
                $initialBudget = '0';
                
                // 2. Créer le groupe et récupérer son nouvel ID
                $newGroupeId = $groupeManager->setGroupe($name, $initialBudget, $code);
                
                if ($newGroupeId) {
                    $userId = (string)$_SESSION['user_id'];
                    
                    // 3. Lier l'utilisateur créateur au groupe
                    if ($participantManager->linkUserToGroup($userId, $newGroupeId)) {
                        
                        // Succès : Redirection vers la page du nouveau groupe (par exemple)
                        $this->redirect('index.php?route=groupe&id=' . $newGroupeId);
                        return;
                    } else {
                        // Optionnel : Supprimer le groupe créé si la liaison échoue
                        // (Non implémenté ici pour la simplicité)
                        $error = "Le groupe a été créé mais la liaison avec l'utilisateur a échoué.";
                    }
                } else {
                    $error = "Échec de la création du groupe (le code est peut-être déjà utilisé).";
                }
            }
        }
        
        // Afficher le formulaire de création avec l'erreur si elle existe
        $this->render('../groupe/create', ['error' => $error]);
    }
}