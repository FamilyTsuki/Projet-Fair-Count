<?php

class GroupeManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    
    }

    public function SetGroupe(string $name, string $budget, string $code){
        $query = $this->db->prepare("
            INSERT INTO groupe (name, budget, code) 
            VALUES (:name, :budget, :code)
        ");
        
        return $query->execute([
            'name' => $name,
            'budget' => $budget,
            'code' => $code,
        ]);
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
}