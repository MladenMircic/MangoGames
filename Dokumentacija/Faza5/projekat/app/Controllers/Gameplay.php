<?php

namespace App\Controllers;

use App\Models\SongModel;

class Gameplay extends BaseController
{
    protected $songs;

    public function showView($page, $welcome, $data = []){
        $data['middlePart'] = view("pages/$page", $data);
        if($welcome == "true")
            $data['welcomeMessage'] = "Welcome,<br> <b>{$this->session->get('username')}</b>";
        echo view("patterns/default_page_pattern", $data);
    }

    public function index()
    {
        $songModel = new SongModel();
        $songs = $songModel->findAll();
        $song1 = rand(0, count($songs));
        echo $song1;
        //$this->showView('game', 'false');
    }

    public function pickSongs() {

    }
}
