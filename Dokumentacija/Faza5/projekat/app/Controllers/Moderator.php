<?php

namespace App\Controllers;

use App\Models\PlaylistModel;
use App\Models\SongModel;


class Moderator extends BaseController
{
    public function showView($page, $data)
    {
        $data['middlePart'] = view("pages/$page", $data);
        $data['welcomeMessage'] = "Welcome, {$this->session->get('username')} <br> <div style='color: blue'>Moderator</div>";
        echo view('patterns/default_page_pattern', $data);
    }

    public function index()
    {
        $this->showView('modMenu', []);
    }

    public function addPlayList(){
        $this->showView("addPlaylist", []);
    }

    public function echoView($name){
        echo view("pages/$name");
    }

    public function getPlaylists(){
        $playlistModel=new PlaylistModel();
        $playlists=$playlistModel->findAll();
        foreach ($playlists as $pl){
            $name=$pl->genre."/".$pl->difficulty."/".$pl->number.",";
            echo ($name);

        }
    }
    public function insertSong(){

        $songModel=new SongModel();
        $playlistModel=new PlaylistModel();
        $multipleWhere = ['genre' => $this->request->getVar('genre'), 'difficulty' => $this->request->getVar('difficulty'), 'number'=>$this->request->getVar('number')];

        $pl= $playlistModel->where($multipleWhere)->findAll();
//
        $songModel->insert([
            "idS"=>   "1",
            "name" => $this->request->getVar('name'),
            "artist"=>  $this->request->getVar('performer'),
            "path"=> $this->request->getVar('location'),
            "idP"=> $pl[0]->idP
        ]);


    }


}
