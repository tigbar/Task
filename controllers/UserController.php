<?php

 namespace controllers;

 use lib\DataBase;
 use lib\Session;
 use models\User;


 class UserController extends DefaultController
 {
//     public function __construct(){
//         $userModel = new User();
//         $session = Session::getInstance();
//     }

        protected $id;
        protected $first_name;
        protected $last_name;
        protected $email;
 }