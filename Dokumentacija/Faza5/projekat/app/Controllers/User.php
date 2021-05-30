<?php

namespace App\Controllers;

use App\Models\UserInfoModel;

class User extends BaseController
{

    public function index()
    {
      $this->showView('userInterface', []);
    }

    protected function showAdditionalData() {
        return ['welcomeMessage' => "Welcome,<br> <b>{$this->session->get('username')}</b>"];
    }

    public function setChosenGenre() {
        $this->session->set("chosenGenre", $this->request->getVar("chosenGenre"));
        return [];
    }

    public function goToTraining() {
        $this->session->set("chosenGenre", $this->request->getVar("chosenGenre"));
        return redirect()->to(base_url("Training"));
    }

    public function selectAvailableGenresForUser()
    {
        $userInfoModel = new UserInfoModel();
        $userInfo = $userInfoModel->where('username', $this->session->get('username'))->findAll();
        return ['userInfo' => $userInfo];
    }

    public function getMyGenres() {
        $userInfoModel=new UserInfoModel();
        $infos=$userInfoModel->where('username',$this->session->get('username'))->findAll();
        foreach ($infos as $info){
            echo $info->genre . ",";
        }
    }
    public function getPointsAndTokens() {
        $userInfoModel=new UserInfoModel();
        if($this->request->getVar("genre")=="allGenres"){
            $infos = $userInfoModel->where('username', $this->session->get('username'))->findAll();
            $points=0;
            $tokens=0;
            foreach ($infos as $info){
                $points+=$info->points;
                $tokens+=$info->tokens;
            }
            echo $points . "," . $tokens;
        }
        else {
            $infos = $userInfoModel->where('username', $this->session->get('username'))->
            where('genre', $this->request->getVar("genre"))->findAll();
            echo $infos[0]->points . "," . $infos[0]->tokens;
        }
    }


}