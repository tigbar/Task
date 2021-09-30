<?php

namespace controllers;

use lib\DataBase;
use lib\Session;
use models\Order;
use models\Product;
use models\OrderProduct;

class OrderController extends DefaultController
{
    protected $id;
    protected $user_id;
    protected $sum;
    protected $order_date;

//    public function __construct(){
//        $orderModel = new Order();
//        $productModel = new Product();
//        $session = Session::getInstance();
//    }

    public function insert(){
        $session = Session::getInstance();
        $orderModel = new Order();

        $orderModel->setUserId($_GET['user_id']); //TODO the 'user_id' index must be replaced by User model's id
        $orderModel->setSum($_GET['sum']);
        $orderModel->setOrderDate(date('dd.mm.yyyy'));

        $orderModel->insert();
    }


}