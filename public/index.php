<?php

use controllers\{ProductController, OrderController};

spl_autoload_register(function ($class) {

    $class = str_replace('\\', '/', $class);
    $root = dirname(__DIR__);

    require_once $root . '/' . $class . '.php';
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
    $controller = new OrderController();
    $params = $_GET;
    $controller->approove($params);
}