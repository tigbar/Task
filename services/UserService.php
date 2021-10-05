<?php

 namespace Services;

 use models\User;
 use lib\DataBase;

 class UserService
 {
     public function insert($firstName, $lastName, $email)
     {
         $userModel = new User();
         $db =  new DataBase();

         $userModel->setFirstName($firstName);
         $userModel->setLastName($lastName);
         $userModel->setEmail($email);

         $lastInsert = $userModel->insert();

         return $lastInsert;
     }
 }