<?php
class Groupe_participantManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    
    }
    
    public function getAllGroupe_participant() : array
    {
        $query = $this->db->prepare("SELECT user_id , groupe_id FROM users");
        $parameters = [

        ];
        $query->execute($parameters);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $Users = [];

        foreach($results as $result)
        {
            $User = new groupe_participant($result["user_id"],$result["groupe_id"]);
        
            $groupe_participant[] = $groupe_participant;
        }
        return $groupe_participant;
    }
        public function register(string $user_id, string $groupe_id): bool{
        $query = $this->db->prepare("
            INSERT INTO users (user_id, groupe_id) 
            VALUES (:user_id, :groupe_id)
        ");
        
        return $query->execute([
            'user_id' => $user_id,
            'groupe_id' => $groupe_id,
        ]);
    }
}