<?php
require_once "User.php";

class Acheteur extends User{
    private int $phone;
    private string $image;

    public function __construct($name, $email, $password_hash, $role, $phone, $image){
        parent::__construct($name, $email, $password_hash, $role);
        $this->phone = $phone;
        $this->image = $image;
    }
}