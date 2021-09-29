<?php

namespace lib;

use PDO;

class DataBase
{
    protected static $instance;

    protected $dsn = 'mysql:host=localhost;dbname=task2';
//    protected $db = 'task2';
    protected $user = 'root';
    protected $password = '';

    protected $pdo;



    protected function __construct(){
        $this->pdo = new PDO($this->dsn, $this->user, $this->password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function getInstance(){
        if(!static::$instance){
            static::$instance = new static();
        }
        return static::$instance;
    }

    public function queryOne($query, $binds = []){
        $query = $this->query($query, $binds);
        return $query->fetch();
    }

    public function query($sql, $binds = [], $type='FETCH_OBJ'){
        $query = $this->pdo->prepare($sql);
        $query->execute($binds);
        $query->setFetchMode(PDO::FETCH_OBJ);
        return $query;
    }

    public function queryAll($query, $binds = []){
        $query = $this->query($query, $binds);
        return $query->fetchAll();
    }

    public function lastInsertedId(){
        return $this->pdo->lastInsertId();
    }
}
