<?php

class GroupeManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    
    }
    public function getAllGroupe($id) : array
    {
        $query = $this->db->prepare("SELECT groupe.id , groupe.name , groupe.budget, groupe.code FROM groupe
                                            JOIN groupe_participants on groupe_participants.groupe_id = groupe.id 
                                            JOIN users on groupe_participants.user_id = groupe.id
                                            WHERE users.id = :id;");
        $parametres = [
            ":id" => $id
        ];
        $query->execute($parametres);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $Groupes = [];

        foreach($results as $result)
        {
            $Groupe = new Groupe($result["id"],$result["name"],$result["budget"]);
        
            $Groupes[] = $Groupe;
        }
        return $Groupes;
    }
}