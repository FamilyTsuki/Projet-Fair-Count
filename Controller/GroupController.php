<?php
class GroupeController extends AbstractController
{
    public function create(): void
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('index.php?route=connect'); 
            return;
        }

        $error = null;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $code = filter_input(INPUT_POST, 'code', FILTER_SANITIZE_STRING);
            
            if (!$name || !$code || strlen($code) < 4) {
                 $error = "Le nom et le code doivent être valides (code min 4 caractères).";
            } else {
                $groupeManager = new GroupeManager();
                $participantManager = new Groupe_participantManager();
                
                $initialBudget = '0';
                $newGroupeId = $groupeManager->setGroupe($name, $initialBudget, $code);
                
                if ($newGroupeId) {
                    $userId = (string)$_SESSION['user_id'];
                    if ($participantManager->linkUserToGroup($userId, $newGroupeId)) {
                        $this->redirect('index.php?route=groupe&id=' . $newGroupeId);
                        return;
                    } else {
                        $error = "Le groupe a été créé mais la liaison avec l'utilisateur a échoué.";
                    }
                } else {
                    $error = "Échec de la création du groupe (le code est peut-être déjà utilisé).";
                }
            }
        }
        
        $this->render('../groupe/create', ['error' => $error]);
    }
    public function join(): void {

    if (!isset($_SESSION['user_id'])) {
        $this->redirect('index.php?route=connect'); 
        return;
    }

    $error = null;
    $success = null;
    $userId = (string)$_SESSION['user_id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = filter_input(INPUT_POST, 'name', FILTER_DEFAULT);
        $code = filter_input(INPUT_POST, 'code', FILTER_DEFAULT); 
        
        if (!$name || !$code) {
             $error = "Veuillez entrer le nom du groupe et le code.";
        } else {
            $groupeManager = new GroupeManager();
            $participantManager = new Groupe_participantManager();
            
            $group = $groupeManager->joingroupe($name, $code);
            
            if ($group) {
                $groupeId = $group->getId();
                
                if ($participantManager->isUserAlreadyInGroup($userId, $groupeId)) {
                    $error = "Vous êtes déjà membre de ce groupe.";
                } else {
                    if ($participantManager->linkUserToGroup($userId, $groupeId)) {
                        $this->redirect('index.php?route=compt&code=' . $code);
                        return;
                    } else {
                        $error = "Erreur lors de l'ajout au groupe. Veuillez réessayer.";
                    }
                }
            } else {
                $error = "Aucun groupe trouvé avec ce nom et ce code.";
            }
        }
    }
    
    $this->render("../partials/join_group", [
        'error' => $error,
        'success' => $success 
    ]);
}
}