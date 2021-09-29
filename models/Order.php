<?php

namespace models;

use lib\DataBase;

class Order
{
    protected $id;
    protected $user_id;
    protected $sum;
    protected $order_date;

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getUserId(){
        return $this->user_id;
    }

    public function setUserId($id){
        $this->user_id = $id;
    }

    public function getSum(){
        return $this->sum;
    }

    public function setSum($sum){
        $this->sum = $sum;
    }

    public function getOrderDate(){
        return $this->order_date;
    }

    public function setOrderDate($ordeDate){
        $this->order_date = $ordeDate;
    }

    public static function getTableName(){
        return 'orders';
    }

    public function insert(){
        $db = DataBase::getInstance();
        $table = static::getTableName();
        $sql = "INSERT INTO " . $this->getTableName() . "(`user_id`, `sum`, `order_date`) VALUES (?,?,?)";
        $db->query($sql, [$this->getUserId(), $this->getSum(), $this->getOrderDate()]);
        $this->id = $db->lastInsertedId();
        return $this;
    }
}
