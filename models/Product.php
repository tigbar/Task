<?php

//TODO add all getters and setters

namespace models;

use lib\DataBase;

class Product
{
    protected $id;
    protected $name;
    protected $description;
    protected $price;


    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName(){
        return $this->name;
    }

    public function setName($name){
        $this->name = $name;
    }

    public function getDescription(){
        return $this->description;
    }

    public function setDescription($description){
        $this->description = $description;
    }

    public function getPrice(){
        return $this->price;
    }

    public function setPrice($price){
        $this->price = $price;
    }

    public static function getTableName()
    {
        return 'products';
    }

    public function insert()
    {
        $db = DataBase::getInstance();
        $table = static::getTableName();
        $sql = "INSERT INTO " . $this->getTableName() . "(`name`, `description`, `price`) VALUES (?,?,?)";
        $db->query($sql, [$this->getName(), $this->getDescription(), $this->getPrice()]);
        $this->id = $db->lastInsertedId();
        return $this;
    }

}