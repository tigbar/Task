<?php

namespace controllers;

class DefaultController
{
    public function redirect($url)
    {
        header("Location: $url");
        exit;
    }

    public function loadView($view, $variables = [])
    {
        $viewPath = "../views/{$view}.php";
        extract($variables);
        ob_start();
        require_once $viewPath;
        return ob_get_clean();
    }
}