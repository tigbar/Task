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
        $totalSum = 0;
        $cartProducts = [];
        $cartCounts = [];
        foreach($list['Products'] as $key=>$value){
            if($value['count'] > 0){
                $totalSum += $value['count'] * $value['price'];

                echo $value['name'] . '&nbsp' . $value['price'] . '&nbsp' . $value['description'] . '<br/>';

                array_push($cartProducts, $key);
                array_push($cartCounts, $value['count']);
            }
        }


        setcookie("products", json_encode($cartProducts), time() + (86400 * 30), "/");
        setcookie("counts", json_encode($cartCounts), time() + (86400 * 30), "/");

        echo "<br/><b>Total Price: " . $totalSum . '</b><hr/><br/><br/>';

        $dirname = dirname(__DIR__);
        require_once $dirname . '\views\Product\approove.php';
    }

    public function approove($params){
        $product = new Product();
        $order = new Order();
        $orderProduct = new OrderProduct();

        $db = DataBase::getInstance();
        $productsIDs = $_COOKIE['products'];
        $productsCounts = $_COOKIE['counts'];

        $productsIDs = substr($productsIDs,1);
        $productsIDs = substr_replace($productsIDs, '', -1);

        $productsCounts = substr($productsCounts,1);
        $productsCounts = substr_replace($productsCounts, '', -1);
        $productsCounts = explode(',', $productsCounts);
        $productsCountsFormated = [];
        foreach($productsCounts as $element){
            $element = substr($element,1);
            $element = substr_replace($element, '', -1);
            array_push($productsCountsFormated, $element);
        }

        $sql = 'select * from ' . $product->getTableName() . ' where id in (' . $productsIDs . ')';

        $productsIDs = explode(',', $productsIDs);
        $prods = $db->queryAll($sql, $productsIDs);

            $reciever = 't_barseghyan@yahoo.com';
            $subject = 'Test market approove mail';
            $veryTotalPrice = 0;
            $message = '<!doctype html>
                    <html>
                    <br/>
                        Dear <b>' . $params['firstName'] . ' ' . $params['lastName'] . '</b> You have bout following product: <br/>';
                        foreach($prods as $prod){
                            $message .= '<table border="1px"><tr><td><b>Name</b></td>><td><b>Count</b></td><td><b>Price</b></td><td><b>Description</b></td><td><b>Total price</b></td></tr>
                                                <tr><td>' . $prod->name . '</td><td>' . $_GET['count'] . '</td><td>' . $prod->price . '</td><td>' . $prod->description . '</td><td>' . $_GET['count'] * $prod->price . '</td></tr></table>';

                            $veryTotalPrice += $_GET['count'] * $prod->price;
                        }
            echo $message;

        echo '<br/><b>The price of shopping:</b> ' . $veryTotalPrice;
    }
}