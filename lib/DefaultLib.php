<?php

namespace lib;

abstract class DefaultLib
{
    protected static $instance;

    abstract protected function __construct();

    public static function getInstance(){
      if(!static::$instance){
        static::$instance = new static();
      }
      return static::$instance;
    }
}