<?php
use controllers\UserController;
use controllers\ProductController;

spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class);
//    echo $class;die;
//    require_once __DIR__ . '..\\' . $class . '.php';
    require_once '../' . $class . '.php';
});

$action = $_GET['action'] ?? '';
if(!$action && $_SERVER['REQUEST_URI'] == '/'){
    $action = 'index';
}

if($action == 'index'){
    $controller = new ProductController();
    die($controller->index());
}

if($action == 'insert'){
    $controller = new ProductController();
    die($controller->insert());
}

if($action == 'list'){
    $controller = new ProductController();
    $list = $_GET;
    $controller->addToChart($list);
}

if($action == 'approove'){
    $controller = new ProductController();
    $params = $_GET;
    $controller->approove($params);
    $controller = new OrderController();
    $controller->insert($params);
}