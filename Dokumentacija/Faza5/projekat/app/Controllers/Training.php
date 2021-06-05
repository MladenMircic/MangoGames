<?php

namespace App\Controllers;

use App\Models\PlaylistModel;
use App\Models\SongModel;
use App\Models\UserInfoModel;
use App\Models\UserPlaylistModel;

class Training extends BaseController
{
    public function getSongsFromPlaylists() {
        $songModel = new SongModel();
        $userInfoModel = new UserInfoModel();
        $mode = $this->session->get("mode");
        if ($mode == "train") {
            $userInfo = $userInfoModel->where("username", $this->session->get("username"))->where("genre", $this->session->get("chosenGenre"))->first();
            $userPlaylistModel = new UserPlaylistModel();
            $userPlaylists = $userPlaylistModel->where("idU", $userInfo->idU)->findAll();
            $idPs = [];

            foreach($userPlaylists as $playlist)
                $idPs = array_merge($idPs, [$playlist->idP]);
        }
        else {
            $playlistModel = new PlaylistModel();
            $playlistsForGenre = $playlistModel->where("genre", $this->session->get("chosenGenre"))->findAll();
            $idPs = [];

            foreach($playlistsForGenre as $playlist)
                $idPs = array_merge($idPs, [$playlist->idP]);
        }
        $this->songs = $songModel->whereIn("idP", $idPs)->findAll();
        $this->session->set("songs", $this->songs);
    }

    public function index()
    {
        $this->getSongsFromPlaylists();
        $this->showView('trainingMode');
    }

    public function pickSongs($toJson = false) {
        $data = [];
        $used = [];
        $i = 0;
        $this->songs = $this->session->get("songs");
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
        shuffle($data['songs']);
        array_splice($this->songs, $songToPlayIndex, 1);
        $this->session->set("songs", $this->songs);
        if ($toJson == false)
            return $data;
        else
            return json_encode($data);
    }

    public function saveUserTokens() {
        $userInfoModel = new UserInfoModel();
        $userInfo = $userInfoModel
                                ->where("username", $this->session->get("username"))
                                ->where("genre", $this->session->get("chosenGenre"))
                                ->findAll();
        $userInfoModel
                ->where("username", $this->session->get("username"))
                ->where("genre", $this->session->get("chosenGenre"))
                ->update(null, ["tokens" => $userInfo[0]->tokens + $this->request->getVar("tokens")]);
    }

    public function saveNewUserInfo(){
        $userInfoModel = new UserInfoModel();
        $userInfoModel->insert([
            "username" => $this->session->get("username"),
            "genre" => $this->session->get("chosenGenre"),
            "points" => 0,
            "tokens" => 0
        ]);
        $userInfo = $userInfoModel->where("username", $this->session->get("username"))->where("genre", $this->session->get("chosenGenre"))->first();
        $userPlaylistModel = new UserPlaylistModel();
        $playlistModel = new PlaylistModel();
        $userPlaylistModel->insert([
            'idU' => $userInfo->idU,
            'idP' => $playlistModel->getIdOfMinNumOfGenre($this->session->get("chosenGenre"))
        ]);
    }
}
