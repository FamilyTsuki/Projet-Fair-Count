<?php

class GroupeManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    
    }

    public function setGroupe(string $name, string $budget, string $code): string|false
    {
        $query = $this->db->prepare("
            INSERT INTO groupe (name, budget, code) 
            VALUES (:name, :budget, :code)
        ");
        
        // On initialise le budget à '0' lors de la création si vous voulez
        // mais le code actuel utilise la valeur passée ($budget)
        $success = $query->execute([
            'name' => $name,
            'budget' => $budget, // Vous pourriez vouloir initialiser le budget à '0' ici
            'code' => $code,
        ]);

        if ($success) {
            // !!! Ligne clé : Récupère l'ID inséré
            return $this->db->lastInsertId();
        }
        
        return false;
    }

    public function getAllGroupe($id) : array
    {
        $query = $this->db->prepare("SELECT groupe.id , groupe.name , groupe.budget, groupe.code FROM groupe
                                            JOIN groupe_participants on groupe_participants.groupe_id = groupe.id 
                                            JOIN users on groupe_participants.user_id = users.id
                                            WHERE users.id = :id;");
        $parametres = [
            ":id" => $id
        ];
        $query->execute($parametres);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $Groupes = [];

        foreach($results as $result)
        {
            $Groupe = new Groupe($result["id"],$result["name"],$result["code"],$result["budget"]);
        
            $Groupes[] = $Groupe;
        }
        return $Groupes;
    }
    public function getGroupBycode($code) : Groupe
    {
        $query = $this->db->prepare("SELECT groupe.id , groupe.name , groupe.budget, groupe.code FROM groupe
                                            WHERE groupe.code = :code;");
        $parametres = [
            ":code" => $code
        ];
        $query->execute($parametres);
        $result = $query->fetch(PDO::FETCH_ASSOC);
               
        $Groupe = new Groupe($result["id"],$result["name"],$result["code"],$result["budget"]);
    
    
        return $Groupe;
    }
    // ... dans la classe GroupeManager
    public function addToBudjet($codegroup ,$ajout) : bool { // Retourne true/false
        $query = $this->db->prepare("
            UPDATE groupe 
            SET budget = budget + :ajout 
            WHERE code = :code
        ");
        
        $parametres = [
            ":code" => $codegroup,
            // Convertir en float ici si nécessaire, ou s'assurer que l'input est propre
            ":ajout" => $ajout 
        ];
        
        // On exécute et on retourne le succès de l'opération
        return $query->execute($parametres); 
        // On retire l'appel à $query->fetch(PDO::FETCH_ASSOC);
    }

    public function removeFromBudjet($codegroup, $retrait) : bool {

    $query = $this->db->prepare("
        UPDATE groupe 
        SET budget = GREATEST(budget - :retrait, 0)
        WHERE code = :code
    ");
    
    $parametres = [
        ":code" => $codegroup,
        ":retrait" => $retrait 
    ];
    
    // 2. Exécution et retour du succès
    return $query->execute($parametres); 
}
}