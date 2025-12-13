<?php

class Expenses {
    private $id;
    private $title;
    private $amount;
    private $date;
    private $created_at;
    private $paid_by_id;
    private $category_id;
    private $category_name;
    private $groupe_id;
    public function __construct($id, $title, $amount, $date, $created_at, $paid_by_id, $category_id, $groupe_id, $category_name) {
        $this->id = $id;
        $this->title = $title;
        $this->amount = $amount;
        $this->date = $date;
        $this->created_at = $created_at;
        $this->paid_by_id = $paid_by_id;
        $this->category_id = $category_id;
        $this->groupe_id = $groupe_id;
        $this->category_name = $category_name;
    }
    public function getId() {
        return $this->id;
    }
    public function setcategory_name($name) {
        $this->category_name = $name;
    }
    public function getcategory_name($id) {
        if ($this->category_name);
           {
            return $this ->category_name;
        }
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
    public function getPaidById() {
        return $this->paid_by_id;
    }
    public function getCategoryId() {
        return $this->category_id;
    }
    public function getGroupeId() {
        return $this->groupe_id;
    }
}