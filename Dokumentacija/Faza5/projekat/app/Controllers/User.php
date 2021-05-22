<?php

namespace App\Controllers;

use App\Models\UserInfoModel;

class User extends BaseController
{
    public function showView($page, $data) {
        $data['middlePart'] = view("pages/$page", $data);
        $data['welcomeMessage'] = "Welcome,<br> {$this->session->get('username')}";
        echo view("patterns/default_page_pattern", $data);
    }

    public function index() {
        $this->showView("userInterface", []);
    }

    public function selectGenreToPlay()
    {
        $userInfoModel = new UserInfoModel();
        $userInfo = $userInfoModel->where('username', $this->session->get('username'))->findAll();
        return ['userInfo' => $userInfo];
    }
}