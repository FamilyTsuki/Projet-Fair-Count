<?php

class Groupe_participantManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    }
    public function linkUserToGroup(string $user_id, string $groupe_id): bool
    {
        $query = $this->db->prepare("
            INSERT INTO groupe_participants (user_id, groupe_id) 
            VALUES (:user_id, :groupe_id)
        ");
        
        return $query->execute([
            'user_id' => $user_id,
            'groupe_id' => $groupe_id,
        ]);
    }
}