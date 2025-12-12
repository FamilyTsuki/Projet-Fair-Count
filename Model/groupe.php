<?php

class groupe {
    private $id;
    private $name;
    private $budget;
    public function __construct($id, $name, $budget) {
        $this->id = $id;
        $this->name = $name;
        $this->Groupe_id =$budget;
    }
    public function getId() {
        return $this->id;
    }
    public function getName() {
        return $this->name;
    }
    public function getBudget() {
        return $this->budget;
    }
}