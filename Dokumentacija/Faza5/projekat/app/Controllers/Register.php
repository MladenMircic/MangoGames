<?php

namespace App\Controllers;

use App\Models\UserModel;

class Register extends BaseController
{
    public function showView($page, $data)
    {
        $data['middlePart'] = view("pages/$page", $data);
        echo view('patterns/default_page_pattern', $data);
    }

    public function index()
    {
        $this->showView('register', []);
    }

    public function checkRegisterCredentials()
    {
        if (!$this->validate([
            'username' => 'trim|required|min_length[5]',
            'password' => 'trim|required|min_length[5]',
            'confirmPass' => 'trim|required|matches[password]'
        ])) {
            return $this->showView(['errors' => $this->validator->getErrors()]);
        }

        $userModel = new UserModel();
        $user = $userModel->find($this->request->getVar('username'));

        if ($user != null)
        {
            return $this->showView(['errors' => ['username' => 'User already exists.']]);
        }

        $userModel->insert([
            'username' => $this->request->getVar('username'),
            'password' => $this->request->getVar('password'),
            'type' => 'user'
        ]);
        echo 'Uspesno!';
    }
}
