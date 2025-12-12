<?php

// Assurez-vous d'inclure votre GroupeManager ici
// require_once 'models/GroupeManager.php'; 

class BudgetController 
{
    private GroupeManager $groupeManager; 

    public function __construct()
    {
        // Le contrôleur a besoin du Manager pour parler à la base de données
        $this->groupeManager = new GroupeManager(); 
    }

    public function handleBudjetAddition() : void
    {
        
        if (isset($_POST['montant_ajout']) && isset($_POST['code_groupe'])) 
        {
            $ajout = filter_input(INPUT_POST, 'montant_ajout', FILTER_VALIDATE_FLOAT);
            $codegroup = filter_input(INPUT_POST, 'code_groupe', FILTER_SANITIZE_STRING);
            
            if ($ajout !== false && $ajout > 0 && $codegroup) {
                
                $success = $this->groupeManager->addToBudjet($codegroup, $ajout);
                
                if ($success) {

                    header("Location: index.php?route=compt&code=" . $codegroup);
                    exit; 
                } else {

                    echo "Erreur lors de la mise à jour du budget dans la base de données.";
                }
            } else {
                
                echo "Erreur : Le montant doit être un nombre positif.";
                header("Location: index.php?route=compt&code=" . $codegroup);
            }

        } else {
            
            header("Location: index.php?route=error_page");
            exit;
        }
    }
}