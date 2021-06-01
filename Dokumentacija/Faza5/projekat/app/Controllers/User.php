<?php

namespace App\Controllers;

use App\Models\PlaylistModel;
use App\Models\UserInfoModel;
use App\Models\UserModel;
use App\Models\GenreModel;
use App\Models\UserPlaylistModel;
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

    public function getGenres(){
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

    public function getPlaylists(){

        $genre = $this->request->getVar("chosenGenre");
        $playlistModel = new PlaylistModel();
        $userPlaylistModel = new UserPlaylistModel();
        $userInfoModel = new UserInfoModel();

        $userInfo = $userInfoModel->where("genre", $genre)->where("username", $this->session->get("username"))->findAll();

        $playlists = $playlistModel->where("genre", $genre)->findAll();
        $userPlaylists = $userPlaylistModel->where("idU", $userInfo[0]->idU)->findAll();

        foreach($playlists as $playlist){
            $flag = false;
            foreach ($userPlaylists as $userPlaylist){
                if($playlist->idP == $userPlaylist->idP){
                    $flag = true;
                    break;
                }
            }
            if($flag == true){
               echo   $playlist->difficulty . "," . $playlist->number . "," . $playlist->price . "," . $playlist->idP . "," . "unlocked" . "/";
            }
            else{
                echo  $playlist->difficulty . "," . $playlist->number . "," . $playlist->price . "," . $playlist->idP . "," . "locked" . "/";
            }
        }
    }

    public function getMyTokens(){
        $userInfoModel = new UserInfoModel();
        $genre = $this->request->getVar("chosenGenre");

        $info = $userInfoModel->where("genre", $genre)->where("username", $this->session->get("username"))->findAll();

        echo $info[0]->tokens;
    }

    public function getPlaylistById(){
        $playlistModel = new PlaylistModel();
        $id = $this->request->getVar("idP");

        $playlist = $playlistModel->find($id);

        echo ucfirst($playlist->genre) . " " . ucfirst($playlist->difficulty) . " " . $playlist->number . "/" . $playlist->price;
    }

    public function buyPlaylist(){
        $genre = $this->request->getVar("genre");
        $id = $this->request->getVar("idP");

        $userInfoModel = new UserInfoModel();
        $playlistModel = new PlaylistModel();

        $playlist = $playlistModel->find($id);

        $info = $userInfoModel->where("genre", $genre)->where("username", $this->session->get("username"))->findAll();
        $tokens = $info[0]->tokens;
        $userInfoModel->where("idU", $info[0]->idU)->update(null, ["tokens" => $tokens - $playlist->price]);

        $userPlaylistModel = new UserPlaylistModel();
        $userPlaylistModel->insert([
            "idU" => $info[0]->idU,
            "idP" => $id
        ]);
    }
}