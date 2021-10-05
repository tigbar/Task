<?php

namespace Services;

use models\Order;
use models\User;
use lib\DataBase;

class OrderService
{
    public function insert($userID, $sum, $orderDate)
    {
        $orderModel = new Order();
        $userModel = new User();
        $orderModel->setUserId($userID);
        $orderModel->setSum($sum);
        $orderModel->setOrderDate();

        $inserted = $orderModel->insert($userID, $sum, $orderDate);
        return $inserted;
    }

    public function insertOrderProduct($orderId, $productId, $count)
    {
        $orderModel = new Order();
        $orderModel->insertOrderProduct($orderId, $productId, $count);

    }
}
