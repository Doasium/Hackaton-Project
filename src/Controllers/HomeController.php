<?php

namespace App\Controllers;

use App\Core\Helpers;
use App\Models\ProductModel;

class HomeController
{
    public function index()
    {
        Helpers::view("home/home");
    }

    public function chat()
    {
        Helpers::view("home/chat");
    }
   
    public function logout()
    {
        $userController = new UserController();
        $userController->logout();
        header("Location: /");
    }
}
