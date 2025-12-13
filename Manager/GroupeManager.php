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
    public function getGroupBycode($code) : ?Groupe
    {
        $query = $this->db->prepare("SELECT groupe.id , groupe.name , groupe.budget, groupe.code FROM groupe
                                            WHERE groupe.code = :code;");
        $parametres = [
            ":code" => $code
        ];
        $query->execute($parametres);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if ($result === false) {
            return null;
        }
        $Groupe = new Groupe($result["id"],$result["name"],$result["code"],$result["budget"]);
    
    
        return $Groupe;
    }
    public function addToBudjet($codegroup ,$ajout) : bool {
        $query = $this->db->prepare("
            UPDATE groupe 
            SET budget = budget + :ajout 
            WHERE code = :code
        ");
        
        $parametres = [
            ":code" => $codegroup,
            ":ajout" => $ajout 
        ];
        
        return $query->execute($parametres); 
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
    return $query->execute($parametres); 
}
    public function getGroupParticipants(int $groupeId): array
    {
        $query = $this->db->prepare("
            SELECT u.id, u.username, u.email , u.password , u.created_at
            FROM users u
            JOIN groupe_participants gp ON u.id = gp.user_id 
            WHERE gp.groupe_id = :groupe_id
        ");
        
        $parametres = [
            ":groupe_id" => $groupeId
        ];
        
        $query->execute($parametres);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        
        $participants = [];

        foreach($results as $result)
        {
            $user = new User($result["id"], $result["email"], $result["password"] , $result["username"] , $result["created_at"]); 
            $participants[] = $user;
        }
        
        return $participants;
    }
    public function joingroupe(string $name, string $code): Groupe|false
{
    $query = $this->db->prepare("
        SELECT id, name, budget, code FROM groupe
        WHERE name = :name AND code = :code
    ");
    
    $query->execute([
        ":name" => $name,
        ":code" => $code
    ]);
    
    $result = $query->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        return new Groupe($result["id"], $result["name"], $result["code"], $result["budget"]);
    }
    
    return false;
}
}
?>