<?php

namespace App\Controllers;
use App\Models\UserModel;

class Login extends BaseController
{
    public function showView($page, $data)
    {
        $data['middlePart'] = view("pages/$page", $data);
        $data['footerPart'] = view("pages/loginFooter", $data);
        echo view("patterns/default_page_pattern.php", $data);
    }

    public function index()
    {
        $this->showView('login', []);
    }

    public function checkUserCredentials()
    {
        if(!$this->validate([
            'username' => 'trim|required',
            'password' => 'trim|required'
        ])){
            return $this->showView(['errors' => $this->validator->getErrors()]);
        }

        $userModel = new UserModel();
        $user = $userModel->find($this->request->getVar('username'));

        if($user == null)
        {
            return $this->showView(['errors' => ['username' => "Wrong username"]]);
        }
        if($user->password != $this->request->getVar('password'))
        {
            return $this->showView(['errors' => ['password' => "Wrong password"]]);
        }

        $this->session->set("username", $this->request->getVar('username'));
        return redirect()->to(site_url("User"));
    }
}