<?php


namespace App\Controllers;


class Administrator extends BaseController
{
    public function showView($data){
        $data['middlePart']= view('pages/adminMenu', $data);
        echo view('patterns/default_page_pattern', $data);
    }

    public function index(){
        $this->showView([]);
    }

    public function leaderboards(){
        echo view("pages/temp.html");
    }




}