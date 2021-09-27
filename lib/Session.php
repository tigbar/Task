<?php

namespace lib;

use lib\DefaultLib;

class Session
{
    protected static $instance;

    protected function __construct(){
        session_start();
    }

    public static function getInstance(){
        if(!static::$instance){
            static::$instance = new static();
        }
        return static::$instance;
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function get($key, $defaultValue = null)
    {
        return $_SESSION[$key] ?? $defaultValue;
    }

    public function remove($key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }
}