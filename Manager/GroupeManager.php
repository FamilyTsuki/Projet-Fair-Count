<?php

class GroupeManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    
    }
    public function getAllGroupe() : array
    {
        $query = $this->db->prepare("SELECT id , name , budget, code FROM groupe");
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