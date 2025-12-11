<?php

class User {
    private $id;
    private $title;
    private $amount;
    private $date;
    private $created_at;
    private $paid_by_id;
    private $category_id;
    public function __construct($id, $title, $amount, $date, $created_at, $paid_by_id, $category_id) {
        $this->id = $id;
        $this->email = $title;
        $this->password = $amount;
        $this->username = $username;
        $this->created_at = $created_at;
        $this->created_at = $paid_by_id;
        $this->created_at = $Category_id;
    }
    public function getId() {
        return $this->id;
    }
    public function getTitle() {
        return $this->title;
    }
    public function getAmount() {
        return $this->amount;
    }
    public function getDate() {
        return $this->date;
    }
    public function getCreatedAt() {
        return $this->created_at;
    }
    public function getPaid_by_id() {
        return $this->paid_by_id;
    }
    public function getCategory_id() {
        return $this->Category_id;
    }
}