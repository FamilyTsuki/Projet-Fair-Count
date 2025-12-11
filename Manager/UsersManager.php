<?php

class UsersManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    
    }
    
    public function register(string $email, string $password, string $username): bool
    {
        // 1. Hachage du mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        // 2. Insertion
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
        // 1. Récupération des données utilisateur par email
        $query = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $query->execute(['email' => $email]);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        // 2. Vérification de l'existence et du mot de passe
        if ($result && password_verify($plainPassword, $result['password'])) {
            
            // 3. Succès : Création et retour de l'objet User
            return new User(
                $result["id"], 
                $result["email"], 
                $result["password"], 
                $result["username"], 
                $result["created_at"]
            );
        }

        // Échec
        return null;
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

