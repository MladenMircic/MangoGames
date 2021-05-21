<?php

namespace App\Controllers;

use App\Models\PlaylistModel;

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
        $playlist=new PlaylistModel();
        $playlists=$playlist->findAll();
        foreach ($playlists as $pl){
            $name=$pl->genre."/".$pl->difficulty."/".$pl->number.",";
            echo ($name);

        }
    }
    public function insertSong(){
    echo "succ1";
    }


}
