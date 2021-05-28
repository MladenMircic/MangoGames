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
            return $this->showView('login', ['errors' => $this->validator->getErrors()]);
        }

        $userModel = new UserModel();
        $user = $userModel->find($this->request->getVar('username'));

        if($user == null)
        {
            return $this->showView('login', ['errors' => ['username' => "Wrong username"]]);
        }
        if($user->password != $this->request->getVar('password'))
        {
            return $this->showView('login', ['errors' => ['password' => "Wrong password"]]);
        }

        $this->session->set("username", $this->request->getVar('username'));
        $this->session->set("type", $user->type);

        if($user->type == "admin"){
            return redirect()->to(site_url("Administrator"));
        }
        if($user->type == "mod") {
            return redirect()->to(site_url("Moderator"));
        }
        return redirect()->to(base_url("User"));
    }

}