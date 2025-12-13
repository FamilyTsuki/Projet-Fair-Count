<?php

class UsersManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    
    }
    
    public function register(string $email, string $password, string $username): bool
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $query = $this->db->prepare("
            INSERT INTO users (email, password, username) 
            VALUES (:email, :password, :username)
        ");
        
        return $query->execute([
            'email' => $email,
            'password' => $hashedPassword,
            'username' => $username
        ]);
    }
    
    
    public function login(string $email, string $plainPassword): ?User
    {
        $query = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $query->execute(['email' => $email]);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if ($result && password_verify($plainPassword, $result['password'])) {
            
            return new User(
                $result["id"], 
                $result["email"], 
                $result["password"], 
                $result["username"], 
                $result["created_at"],
                $result["tune"]

            );
        }

        return null;
    }
    public function getUserById(int $id) : User
    {
        $query = $this->db->prepare('SELECT id , email, password ,username,created_at , tune FROM users 
                                            WHERE id = :id ;' );
        $parameters = [
            'id' => $id
        ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        $User = new User($result["id"],$result["email"],$result["password"],$result["username"], $result["created_at"],$result["tune"]);
        return $User;
    }
    public function getAllUsers() : array
    {
        $query = $this->db->prepare("SELECT id , email, password ,username,created_at ,tune FROM users");
        $parameters = [

        ];
        $query->execute($parameters);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $Users = [];

        foreach($results as $result)
        {
            $User = new User($result["id"],$result["email"],$result["password"],$result["username"], $result["created_at"],$result["tune"]);
        
            $Users[] = $User;
        }
        return $Users;
    }
    public function addTuneById(int $id , int $tune) {
        $query = $this->db->prepare("
            UPDATE users 
            SET tune = :tune 
            WHERE id = :id
        ");

        return $query->execute([
            'tune' => $tune,
            'id' => $id
        ]);
    }


}

