<?php

namespace App\Controllers;

use App\Core\Helpers;
use App\Models\LeassonModel;
use App\Models\ProductModel;

class HomeController
{
    public function index()
    {
        $data = (new LeassonModel())->getAllLeassons();
        $html = "";
        foreach ($data as $leassons) {
            $html .= '
            <div class="col">
                <a href="/leasson/watch/' . $leassons["st_u_id"] . '"> 
                <div class="card shadow-sm">
                    <img src="' . $leassons["st_image"] . '">

                    <div class="card-body">
                        <p class="card-text">' . $leassons["st_name"] . '</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <p style="font-size: 13px;font-style: normal;font-weight: 400;">' . $leassons["st_description"] . '</p>
                        </div>
                    </div>
                </div>
                </a>
            </div>';
        }
        Helpers::view("home/home", ["lessons" => $html]);
    }

    public function leasson_view($student_id)
    {
        $data = (new LeassonModel())->getLeassons($student_id);
        Helpers::view("home/leassonview", ["leasson_video" => $data["st_video"]]);
    }

    public function chat()
    {
        Helpers::view("home/chat", ["ah"]);
    }
    public function register()
    {
        Helpers::view("home/register");
    }
    public function login()
    {
        Helpers::view("home/login");
    }

    public function quests()
    {
        $data = (new LeassonModel())->getAllQuestsCategories();
        $html = "";
        $number = 1;
        foreach ($data as $quest) {
            $html .= '
            <div class="col">
                <a class="text-decoration-none" href="/leasson/quest/' . $quest["q_u_id"] . '"> 
                <div class="card shadow-sm ">
                    <img src="' . $quest["image"] . '" >

                    <div class="card-body">
                        <p class="card-text">Soru: ' . $quest["name"] . ' #' . $number . ' - '.$quest["q_language"].' </p>
                        <div class="d-flex justify-content-between align-items-center">
                        <p style="font-size: 13px;font-style: normal;font-weight: 400;">'.$detay = mb_substr($quest["q_quest"],0,30) . "...".'</p>
                        </div>
                    </div>
                </div>
                </a>
            </div>';    
            $number++;
        }
        Helpers::view("home/quests", ["quests_categories" => $html]);
    }

    public function quest_view($quest_id){
        $data = (new LeassonModel())->getQuest($quest_id);
        Helpers::view("home/code_quest",["quest" => $data["q_quest"]]);
    }

    public function code_analize()
    {
        Helpers::view("home/code_analize");
    }
    public function logout()
    {
        $userController = new UserController();
        $userController->logout();
        header("Location: /");
    }
}
