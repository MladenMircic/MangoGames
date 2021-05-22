<?php

namespace App\Controllers;

use App\Models\UserInfoModel;

class User extends BaseController
{
    public function showView($page, $welcome, $data = []){
        $data['middlePart'] = view("pages/$page", $data);
        if($welcome == "true")
            $data['welcomeMessage'] = "Welcome,<br> {$this->session->get('username')}";
        echo view("patterns/default_page_pattern", $data);
    }

    public function index()
    {
      $this->showView('userInterface', "true", []);
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to(site_url('Login'));
    }

    public function selectGenreToPlay()
    {
        $userInfoModel = new UserInfoModel();
        $userInfo = $userInfoModel->where('username', $this->session->get('username'))->findAll();
        return ['userInfo' => $userInfo];
    }
}