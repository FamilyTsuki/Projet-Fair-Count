<?php

class GroupeManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    
    }
    public function getAllGroupe() : array
    {
        $query = $this->db->prepare("SELECT groupe.id , groupe.name , groupe.budget, groupe.code FROM groupe
                                            JOIN groupe_participants on groupe_participants.groupe_id = groupe.id 
                                            JOIN users on groupe_participants.user_id = groupe.id
                                            WHERE users.id = 4;");
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $Groupes = [];

        foreach($results as $result)
        {
            $Groupe = new Groupe($result["id"],$result["name"],$result["budget"],$result["code"]);
        
            $Groupes[] = $Groupe;
        }
        return $Groupes;
    }
}