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
//        print_r($_GET);

        $this->productModel = new Product();

        $session = Session::getInstance();

        if($_POST) {
            $this->productModel->setName($_POST['name']);
            $this->productModel->setDescription($_POST['description']);
            $this->productModel->setPrice($_POST['price']);

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

        $totalCount = $db->queryOne('SELECT COUNT(*) as total FROM ' . $this->productModel->getTableName());

        $totalPages = 3; /*ceil($totalCount / $perPage);*/

        if ($page > $totalPages) {
            $page = $totalPages;
        }

        $offset = ($page - 1) * $perPage;

        $sortQuery = '';
        if ($sort && in_array($sort, ['id', 'name', 'description', 'price'])) {
            $dir = $dir == 'asc' ? $dir : 'desc';
            $sortQuery = "ORDER BY $sort $dir";
        }

        $products = $db->queryAll('SELECT * FROM ' . $this->productModel->getTableName());


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
        $cartProducts = [];
        foreach($list['Products'] as $key=>$value){
            if($value['count'] > 0){
                $totalSum += $value['count'] * $value['price'];

                echo $value['name'] . '&nbsp' . $value['price'] . '&nbsp' . $value['description'] . '<br/>';

                array_push($cartProducts, $key);
            }
        }
        setcookie("products", json_encode($cartProducts), time() + (86400 * 30), "/");

        echo "<br/><b>Total Price: " . $totalSum . '</b><hr/><br/><br/>';

        require_once dirname(__DIR__) . '\views\Product\approove.php';
    }

    public function approove($params){
        $product = new Product();
        $order = new Order();
        $orderProduct = new OrderProduct();


        $db = DataBase::getInstance();
        $productsIDs = $_COOKIE['products'];


        $productsIDs = substr($productsIDs,1);
        $productsIDs = substr_replace($productsIDs, '', -1);

        $productsIDs = explode(',', $productsIDs);

//        $productsIDs = json_encode($productsIDs);
//        print_r($productsIDs);

        $sql = 'select * from ' . $product->getTableName() . ' where id in (';
        foreach($productsIDs as $id){
            $sql .= $id . ',';
        }
        $sql = substr_replace($sql, '', -1);
        $sql .= ')';
        $prods = $db->queryOne($sql, $productsIDs);
//        var_dump($prods);die;
//        echo $sql;die;

        $reciever = 't_barseghyan@yahoo.com';
        $subject = 'Test market approove mail';
        $message = '<!doctype html>
                    <html>
                    <br/>
                        <b>Dear ' . $params['firstName'] . ' ' . $params['lastName'] . 'You have bout following products: </b>';
//                        foreach($prods as $prod){
                            $message .= '<b>Name- </b>' . $prods['name']
                                        . '<br/><b>Count- </b>' . $prods['count']
                                        . '<br/><b>Price- </b>' . $prods['price']
                                        . '<br><b>Description- </b>' . $prods['description']
                                        . '<br/><b>Total price- </b>' . $prods['count'] * $prods['price']
                                        . '. <br/>'
                                        . '<p>Thank you.</p>';
//                        }
        echo $message;

    }
}