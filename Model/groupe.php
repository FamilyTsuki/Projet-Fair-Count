<?php

class groupe {
    private $id;
    private $name;
    private $budget;
    private $code;
    public function __construct($id, $name, $budget, $code) {
        $this->id = $id;
        $this->name = $name;
        $this->Groupe_id =$budget;
        $this->code = $code;
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
    public function getCode() {
        return $this->code;
    }
}