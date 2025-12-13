<?php

class User {
    private $id;
    private $email;
    private $password;
    private $username;
    private $created_at;
    private $tune;
    public function __construct($id, $email, $password, $username, $created_at, $tune = 0) {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->username = $username;
        $this->created_at = $created_at;
        $this->tune = $tune;
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
    public function getTune() {
        return $this->tune;
    }
    public function addTune($tune) {
        $this->tune = $this->tune + $tune;
    }

    
}