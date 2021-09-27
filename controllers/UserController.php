<?php

 namespace controllers;

 use lib\DataBase;
 use lib\Session;
 use models\User;


 class UserController extends DefaultController
 {
     public function index(){
         $userModel = new User();
         $session = Session::getInstance();
     }
 }