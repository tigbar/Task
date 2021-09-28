<?php

namespace models;

use lib\DataBase;

class User
{
    protected $id;
    protected $first_name;
    protected $last_name;
    protected $email;

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getFirstName(){
        return $this->first_name;
    }

    public function setFirstName($name){
        $this->first_name = $name;
    }

    public function getLastName(){
        return$this->last_name;
    }

    public function setLastName($name){
        $this->last_name = $name;
    }

    public function getEmail(){
        return $this->email;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function getTableName(){
        return 'users';
    }
}