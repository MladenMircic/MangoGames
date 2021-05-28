<?php

namespace App\Controllers;

use App\Models\SongModel;
use App\Models\UserInfoModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Gameplay extends BaseController
{
    protected $songs;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        $songModel = new SongModel();
        $this->songs = $songModel->findAll();
    }

    public function showView($page, $welcome, $data = []) {
        $data['middlePart'] = view("pages/$page", $data);
        if($welcome == "true")
            $data['welcomeMessage'] = "Welcome,<br> <b>{$this->session->get('username')}</b>";
        echo view("patterns/default_page_pattern", $data);
    }

    public function index()
    {
        $this->showView('game', 'false');
    }

    public function pickSongs($toJson = false) {
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
        shuffle($data['songs']);
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
}
