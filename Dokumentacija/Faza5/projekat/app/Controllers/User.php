<?php

namespace App\Controllers;

use App\Models\UserInfoModel;
use App\Models\UserModel;

class User extends BaseController
{
    public function showView($page, $welcome, $data = []){
        $data['middlePart'] = view("pages/$page", $data);
        if($welcome == "true")
            $data['welcomeMessage'] = "Welcome,<br> <b>{$this->session->get('username')}</b>";
        echo view("patterns/default_page_pattern", $data);
    }

    public function index()
    {
      $this->showView('userInterface', "true", []);
    }

    public function setChosenGenre() {
        $this->session->set("chosenGenre", $this->request->getVar("chosenGenre"));
        return [];
    }

    public function goToTraining() {
        $this->session->set("chosenGenre", $this->request->getVar("chosenGenre"));
        return redirect()->to(base_url("Gameplay"));
    }

    public function selectAvailableGenresForUser()
    {
        $userInfoModel = new UserInfoModel();
        $userInfo = $userInfoModel->where('username', $this->session->get('username'))->findAll();
        return ['userInfo' => $userInfo];
    }

    public function getMyGenres(){
        $userInfoModel=new UserInfoModel();
        $infos=$userInfoModel->where('username',$this->session->get('username'))->findAll();
        foreach ($infos as $info){
            echo $info->genre.",";
        }
    }
    public function getPointsAndTokens(){
        $userInfoModel=new UserInfoModel();
        if($this->request->getVar("genre")=="allGenres"){
            $infos = $userInfoModel->where('username', $this->session->get('username'))->findAll();
            $points=0;
            $tokens=0;
            foreach ($infos as $info){
                $points+=$info->points;
                $tokens+=$info->tokens;
            }
            echo $points . "," .$tokens;
        }
        else {
            $infos = $userInfoModel->where('username', $this->session->get('username'))->
            where('genre', $this->request->getVar("genre"))->findAll();
            echo $infos[0]->points . "," . $infos[0]->tokens;
        }
    }

    public function getGenrePoints(){
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
            foreach($arr as $key=>$a){
                echo $key."/".$a.",";

            }
        }
        else{
            $infos=$userInfoModel->where('genre', $this->request->getVar("genre"))->findAll();
            foreach ($infos as $info){
                echo $info->username."/".$info->points.",";
            }
        }
        echo $this->session->get('username');
    }
}