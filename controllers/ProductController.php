<?php

namespace controllers;

use lib\DataBase;
use lib\Session;
use models\Product;
use models\Order;
use models\OrderProduct;

class ProductController extends DefaultController
{

    protected $productModel;

    public function index(){

        $this->productModel = new Product();

        $session = Session::getInstance();

        if($_POST) {
            $this->productModel->setName($_POST['name']);
            $this->productModel->setDescription($_POST['description']);
            $this->productModel->setPrice($_POST['price']);

            $session->set('newProduct', true);
            $this->redirect('/');
        }

        $db = DataBase::getInstance();

        $products = $db->queryAll('SELECT * FROM ' . $this->productModel->getTableName());

        $newProductCreated = $session->get('newProduct', false);
        if ($newProductCreated) {
            $session->remove('newProduct');
        }

        return $this->loadView('product/index', compact('products'));

    }

    public function insert(){

        if($_GET['action'] == 'insert') {
            $productModel = new Product();
            $session = Session::getInstance();

            $productModel->setName($_GET['name']);
            $productModel->setDescription($_GET['description']);
            $productModel->setPrice($_GET['price']);

            $productModel->insert();

            $session->set('newProduct', true);
            $this->index();
        }

    }

    public function addToChart($list){
        $totalSum = 0;
        $cartProducts = [];
        $cartCounts = [];
        foreach($list['Products'] as $key=>$value){
            if($value['count'] > 0){
                $totalSum += $value['count'] * $value['price'];

                echo $value['name'] . '&nbsp' . $value['price'] . '&nbsp' . $value['description'] . '<br/>';


                $cartProducts[$key] = [];
                array_push($cartProducts[$key], $value['name']);
                array_push($cartProducts[$key], $value['count']);
                array_push($cartProducts[$key], $value['price']);
                array_push($cartProducts[$key], $value['description']);
            }
        }

        setcookie("products", json_encode($cartProducts), time() + (86400 * 30), "/");

        echo "<br/><b>Total Price: " . $totalSum . '</b><hr/><br/><br/>';

        $dirname = dirname(__DIR__);
        require_once $dirname . '\views\Product\approove.php';
    }


}