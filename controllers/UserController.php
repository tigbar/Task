<?php

 namespace controllers;

 use services\UserService;
 use models\User;

 class UserController extends UserService
 {
//     public function __construct(){
//         $userModel = new User();
//         $session = Session::getInstance();
//     }

        protected $id;
        protected $first_name;
        protected $last_name;
        protected $email;


        public function insert($firstName, $lastName, $email)
        {
            $userModel = new User();
            $userService = new UserService();

            $lastInserted = $userService->insert($firstName, $lastName, $email);
            $userModel->setId($lastInserted);
        }
 }