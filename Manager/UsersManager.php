<?php

class UsersManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    
    }

    public function getUserById(int $id) : User
    {
        $query = $this->db->prepare('SELECT id , email, password ,username,created_at FROM users 
                                            WHERE id = :id ;' );
        $parameters = [
            'id' => $id
        ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        $User = new User($result["id"],$result["email"],$result["password"],$result["username"], $result["created_at"]);
        return $User;
    }
    public function getAllUsers() : array
    {
        $query = $this->db->prepare("SELECT id , email, password ,username,created_at FROM users");
        $parameters = [

        ];
        $query->execute($parameters);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $Users = [];

        foreach($results as $result)
        {
            $User = new User($result["id"],$result["email"],$result["password"],$result["username"], $result["created_at"]);
        
            $Users[] = $User;
        }
        return $Users;
    }


}

