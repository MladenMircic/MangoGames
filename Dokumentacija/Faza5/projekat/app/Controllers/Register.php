<?php

namespace App\Controllers;

use App\Models\GenreModel;
use App\Models\UserInfoModel;
use App\Models\UserModel;
use CodeIgniter\Model;

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
            return $this->showView('register',['errors' => $this->validator->getErrors()]);
        }

        $userModel = new UserModel();
        $user = $userModel->find($this->request->getVar('username'));

        if ($user != null)
        {
            return $this->showView('register',['errors' => ['username' => 'User already exists.']]);
        }

        $userModel->insert([
            'username' => $this->request->getVar('username'),
            'password' => $this->request->getVar('password'),
            'type' => 'user'
        ]);
        $this->session->set("username", $this->request->getVar('username'));
        $this->pickGenres();

    }

    public function pickGenres(){
        $genreModel=new GenreModel();
        $data['genres'] =$genreModel->findAll();
        $this->showView('pickGenres',$data);

    }

    public function confirmGenres(){
        $userInfo=new UserInfoModel();
        $userInfo->insertBatch([
            "username" => [$this->session->get("username"), $this->session->get("username")],
            "genre"=> [$this->request->getVar('g1'), $this->request->getVar('g2')]
        ]);
        redirect()->to(site_url("User"));

        //echo ($this->request->getVar('g1'));
    }




}
