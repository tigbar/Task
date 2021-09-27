<?php

namespace controllers;

use lib\DataBase;
use lib\Session;
use models\Product;

class ProductController extends DefaultController
{
    public function index(){
//        print_r($_GET);

        $productModel = new Product();
        $session = Session::getInstance();

        if($_POST) {
            $productModel->setName($_POST['name']);
            $productModel->setDescription($_POST['description']);
            $productModel->setPrice($_POST['price']);

            $session->set('newProduct', true);
            $this->redirect('/');
        }

        $sort = $_GET['sort'] ?? 'id';
        $dir = $_GET['dir'] ?? 'desc';

        $page = $_GET['page'] ?? 1;
        $page = intval($page);
        if (!$page) {
            $page = 1;
        }

        $perPage = 3;

        $db = DataBase::getInstance();

        $totalCount = $db->queryOne('SELECT COUNT(*) as total FROM ' . Product::getTableName())->total;

        $totalPages = ceil($totalCount / $perPage);

        if ($page > $totalPages) {
            $page = $totalPages;
        }

        $offset = ($page - 1) * $perPage;

        $sortQuery = '';
        if ($sort && in_array($sort, ['id', 'name', 'description', 'price'])) {
            $dir = $dir == 'asc' ? $dir : 'desc';
            $sortQuery = "ORDER BY $sort $dir";
        }

        $products = $db->queryAll('SELECT * FROM ' . Product::getTableName());


        $newProductCreated = $session->get('newProduct', false);
        if ($newProductCreated) {
            $session->remove('newProduct');
        }

        return $this->loadView('product/index', compact('page', 'totalPages', 'sort', 'dir', 'products', 'newProductCreated'));

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
//        echo '<pre>'; print_r($list);die;
        $totalSum = 0;
        foreach($list['Products'] as $product){
            if($product['count'] > 0){
                $totalSum += $product['count'] * $product['price'];
                echo $product['name'] . '&nbsp' . $product['price'] . '&nbsp' . $product['description'] . '<br/>';
            }
        }
        echo "<br/><b>Total Price: " . $totalSum . '</b><hr/><br/><br/>';

        setcookie('byed', $list['Products'], time() + (86400 * 30), "/");


        echo '<form method="get" action="/">
                  <input type="hidden" name="action" value="approove">
                  <b>First name:</b>
                  <input type="text" name="firstName">
                  <br/><br/>
                  <b>Last name:</b>
                  <input type="text" name="lastName">
                  <br/><br/>
                  <b>email:</b>
                  <input type="text" name="email">
                  <br/><br/>
                  <input type="submit" value="Approove">';
    }

    public function approove($params){

    }
}