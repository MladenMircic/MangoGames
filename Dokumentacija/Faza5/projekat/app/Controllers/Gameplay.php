<?php

namespace App\Controllers;

class Gameplay extends BaseController
{
    public function showView($page, $welcome, $data = []){
        $data['middlePart'] = view("pages/$page", $data);
        if($welcome == "true")
            $data['welcomeMessage'] = "Welcome,<br> <b>{$this->session->get('username')}</b>";
        echo view("patterns/default_page_pattern", $data);
    }

    public function index()
    {
        $this->showView('game', 'false');
    }
}
