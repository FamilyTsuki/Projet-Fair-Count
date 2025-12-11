<?php

class UsersManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    
    }

    public function getUserById(int $id) : User
    {
        $query = $this->db->prepare('SELECT id , email, password ,players.team FROM users 
                                            WHERE players.id = :id ;' );
        $parameters = [
            'id' => $id
        ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        $User = new User($result["id"],$result["nickname"],$result["bio"],$result["portrait"], $result["team"]);
        return $User;
    }
    public function getAllUsers() : array
    {
        $query = $this->db->prepare("SELECT players.id , players.nickname,players.bio,media.url as portrait ,players.team FROM players 
                                            JOIN media on players.portrait = media.id");
        $parameters = [

        ];
        $query->execute($parameters);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $Users = [];

        foreach($results as $result)
        {
            $User = new User($result["id"],$result["nickname"],$result["bio"],$result["portrait"], $result["team"]);
            $Users[] = $User;
        }
        return $Users;
    }


}

