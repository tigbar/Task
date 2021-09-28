<?php

namespace models;

use lib\DataBase;

class OrderProduct
{
    protected $id;
    protected $order_id;
    protected $product_id;
    protected $qty;

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getOrderId(){
        return $this->order_id;
    }

    public function setOrderId($id){
        $this->order_id = $id;
    }

    public function getProductId(){
        return $this->product_id;
    }

    public function setProductId($id){
        $this->product_id = $id;
    }

    public function getQty(){
        return $this->qty;
    }

    public function setQty($qty){
        $this->qty = $qty;
    }

    public static function getTableName(){
        return 'order_products';
    }
}