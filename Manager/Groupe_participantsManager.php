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
    public function isUserAlreadyInGroup(string $user_id, string $groupe_id): bool {
    $query = $this->db->prepare("
        SELECT COUNT(*) 
        FROM groupe_participants 
        WHERE user_id = :user_id AND groupe_id = :groupe_id
    ");

    $query->execute([
        ':user_id' => $user_id,
        ':groupe_id' => $groupe_id,
    ]);

    return (bool) $query->fetchColumn(); 
}
}