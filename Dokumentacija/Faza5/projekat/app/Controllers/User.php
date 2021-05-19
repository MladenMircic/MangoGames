<?php


namespace App\Controllers;


class User extends BaseController
{
    public function showView($page, $data){
        $data['middlePart'] = view("pages/$page", $data);
        $data['welcomeMessage'] = "Welcome, {$this->session->get('username')}";
        echo view("patterns/default_page_pattern", $data);
    }

    public function index(){
        $this->showView("userInterface", []);
    }
}