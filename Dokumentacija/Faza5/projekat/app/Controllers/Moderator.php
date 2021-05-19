<?php

namespace App\Controllers;

class Moderator extends BaseController
{
    public function showView($page, $data)
    {
        $data['middlePart'] = view("pages/$page", $data);
        $data['welcomeMessage'] = "Welcome, {$this->session->get('username')} <br> <div style='color: blue'>Moderator</div>";
        echo view('patterns/default_page_pattern', $data);
    }

    public function index()
    {
        $this->showView('modMenu', []);
    }
}
