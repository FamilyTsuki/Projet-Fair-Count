
<?php


class User {
    private $id;
    private $email;
    private $password;
    private $username;
    private $created_at;
    public function __construct($id, $email, $password, $username, $created_at) {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->username = $username;
        $this->created_at = $created_at;
    }
    public function getId() {
        return $this->id;
    }
    public function getEmail() {
        return $this->email;
    }
    public function getPassword() {
        return $this->password;
    }
    public function getUsername() {
        return $this->username;
    }
    public function getCreatedAt() {
        return $this->created_at;
    }
    
}