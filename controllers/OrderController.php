<?php

namespace controllers;

use models\Order;
use models\Product;
use models\User;
use Services\OrderService;
use services\UserService;

class OrderController extends DefaultController
{
    protected $id;
    protected $user_id;
    protected $sum;
    protected $order_date;

    public function approove($params){

        $user = new UserService();
        $orderService = new OrderService();
        $product = new Product();

        $cartProducts = $_COOKIE['products'];

        $prods = json_decode($cartProducts, true);

        $userID = $user->insert($params['firstName'], $params['lastName'], $params['email']);

        $bigSum = 0;
        foreach ($prods as $key=>$value) {
            $bigSum += $value[1] * $value[2];
        }
        $inserted = $orderService->insert($userID, $bigSum, date('Y.m.d'));
        foreach ($prods as $key=>$value) {
            $orderService->insertOrderProduct($inserted, $key, $value[1]);
        }



        $dirname = dirname(__DIR__);
        require_once $dirname . '\views\order\mail.php';
    }

    public function insert($userID, $sum)
    {
        $orderModel = new Order();
        $orderService = new OrderService();

        $lastInserted = $orderService->insert($userID, $sum, date('Y.m.d'));
    }

    public function selectOne($id)
    {
        $orderModel = new Order();
        $this->id = $id;

        $orderModel->selectOne($this->id);
    }


}