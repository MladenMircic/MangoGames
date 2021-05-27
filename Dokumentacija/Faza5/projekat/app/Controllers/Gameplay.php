<?php

namespace App\Controllers;

use App\Models\SongModel;

class Gameplay extends BaseController
{
    protected $songs;

    public function showView($page, $welcome, $data = []) {
        $data['middlePart'] = view("pages/$page", $data);
        if($welcome == "true")
            $data['welcomeMessage'] = "Welcome,<br> <b>{$this->session->get('username')}</b>";
        echo view("patterns/default_page_pattern", $data);
    }

    public function index()
    {
        $songModel = new SongModel();
        $this->songs = $songModel->findAll();
//        foreach($this->songs as $song)
//            echo $song->name . "<br>";
        $data = $this->pickSongs();
        $this->showView('game', 'false', $data);
    }

    public function pickSongs() {
        $data = [];
        $used = [];
        $i = 0;
        $songToPlayIndex = rand(0, count($this->songs) - 1);
        $data['songToBePlayed'] = $this->songs[$songToPlayIndex];
        $data['songs'] []= $this->songs[$songToPlayIndex]->name;
        while ($i < 3) {
            $currentSongNumber = rand(0, count($this->songs) - 1);
            if (in_array($currentSongNumber, $used) || $this->songs[$currentSongNumber]->name == $data['songToBePlayed']->name)
                continue;
            $data['songs'] []= $this->songs[$currentSongNumber]->name;
            $used []= $currentSongNumber;
            $i++;
        }
        return $data;
    }
}
