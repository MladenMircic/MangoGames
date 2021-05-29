<?php

namespace App\Controllers;
use App\Models\UserModel;

class Login extends BaseController
{
    public function index()
    {
        $this->showView('login');
    }

    protected function showAdditionalData()
    {
        return ['footerPart' => view("pages/loginFooter")];
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
            return redirect()->to(base_url("Administrator"));
        }
        if($user->type == "mod") {
            return redirect()->to(base_url("Moderator"));
        }
        return redirect()->to(base_url("User"));
    }

}