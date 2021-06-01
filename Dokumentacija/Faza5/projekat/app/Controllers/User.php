<?php

namespace App\Controllers;

use App\Models\UserInfoModel;
use App\Models\UserModel;
use App\Models\GenreModel;
use CodeIgniter\Model;

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
        $this->session->set("mode", $this->request->getVar("mode"));
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


    public function getGenrePoints() {
        $userInfoModel=new UserInfoModel();
        if($this->request->getVar("genre")=="allGenres"){
            $arr=[];
            $infos=$userInfoModel->findAll();
            foreach($infos as $info){
                if(array_key_exists($info->username, $arr))
                    $arr[$info->username]+=$info->points;
                else
                    $arr[$info->username]=$info->points;
            }
            foreach($arr as $key => $value)
                echo $key . "/" . $value . ",";
        }
        else {
            $infos=$userInfoModel->where('genre', $this->request->getVar("genre"))->findAll();
            foreach ($infos as $info)
                echo $info->username."/".$info->points.",";
        }
        echo $this->session->get('username');
    }

    public function saveTokens() {
        $userInfoModel = new UserInfoModel();
        $userInfo = $userInfoModel
                                ->where("username", $this->session->get("username"))
                                ->where("genre", $this->session->get("chosenGenre"))
                                ->findAll();
        $userInfoModel
                    ->where("username", $this->session->get("username"))
                    ->where("genre", $this->session->get("chosenGenre"))
                    ->update(null, ["tokens" => $userInfo[0]->tokens + $this->request->getVar("tokens")]);

        session()->remove("chosenGenre");
    }

    public function showEnd() {
        $this->showView('endGameScreen');
    }

    public function getGenres() {
        $genreModel = new GenreModel();
        $userInfo = new UserInfoModel();
        $user = $this->session->get("username");

        $infos = $userInfo->where("username", $user)->findAll();
        $genres = $genreModel->findAll();

        $toSend = [];

        foreach ($genres as $genre){
            $flag = false;
            foreach($infos as $info){
                if($info->genre == $genre->name){
                    $flag = true;
                    break;
                }
            }
            if($flag == true){
                $toSend[$genre->name] = "unlocked";
            }
            else{
                $toSend[$genre->name] = "locked";
            }
        }

        return ["genres" => $toSend];
    }
}