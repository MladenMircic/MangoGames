<?php

namespace App\Controllers;

use App\Models\PlaylistModel;
use App\Models\SongModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class PrivilegedUser extends BaseController
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

    }

    public function getPlaylists() {
        $playlistModel=new PlaylistModel();
        $playlists=$playlistModel->findAll();
        foreach ($playlists as $pl){
            $name=$pl->genre."/".$pl->difficulty."/".$pl->number."/".$pl->idP.",";
            echo ($name);
        }
    }

    public function deletePlaylist() {
        $playlistModel=new PlaylistModel();
        $playlistModel->delete($this->request->getVar('idP'));
    }

    public function deleteSong() {
        $songModel=new SongModel();
        $songModel->delete($this->request->getVar('idS'));
    }

    public function getSongs(){
        $songModel=new SongModel();
        $playlistModel=new PlaylistModel();
        $multipleWhere = ['genre' => $this->request->getVar('genre'), 'difficulty' => $this->request->getVar('difficulty'), 'number'=>$this->request->getVar('number')];

        $pl= $playlistModel->where($multipleWhere)->findAll();
        $songs=$songModel->where('idP', $pl[0]->idP)->findAll();
        foreach($songs as $song){
            $name=$song->name."/".$song->artist."/".$song->idS.",";
            echo ($name);
        }
    }

    public function insertSong(){

        $songModel=new SongModel();
        $playlistModel=new PlaylistModel();
        $multipleWhere = ['genre' => $this->request->getVar('genre'), 'difficulty' => $this->request->getVar('difficulty'), 'number'=>$this->request->getVar('number')];

        $pl= $playlistModel->where($multipleWhere)->findAll();
        $songModel->insert([
            "name" => $this->request->getVar('name'),
            "artist"=>  $this->request->getVar('performer'),
            "path"=> $this->request->getVar('location'),
            "idP"=> $pl[0]->idP
        ]);
    }

    public function insertPlaylist(){
        $playlistModel=new PlaylistModel();
        $pls=$playlistModel
                            ->where("genre", $this->request->getVar('genre'))
                            ->where("difficulty", $this->request->getVar('level'))
                            ->findAll();
        $arr=array();

        foreach ($pls as $pl)
            array_push($arr , $pl->number);

        if(count($arr)==0) $maxNum=1;
        else $maxNum=max($arr)+1;

        $playlistModel->insert([
            "difficulty" => $this->request->getVar('level'),
            "genre" =>  $this->request->getVar('genre'),
            "number"=> $maxNum
        ]);
    }
}