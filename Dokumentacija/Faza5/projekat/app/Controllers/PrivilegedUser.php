<?php

namespace App\Controllers;

use App\Models\ChangeLogModel;
use App\Models\PlaylistModel;
use App\Models\SongModel;
use App\Models\GenreModel;
use App\Models\UserInfoModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Model;
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
    public function playlistToString($idP){
        $playlistModel=new PlaylistModel();
        $player=$playlistModel->find($idP);
        return ucfirst($player->genre)." ".ucfirst($player->difficulty)." ".ucfirst($player->number);
    }


    public function deletePlaylist(){
        $playlistModel=new PlaylistModel();

        $message="deleted playlist ".$this->playlistToString($this->request->getVar('idP'));
        $this->insertToChangeLog($message);
        $playlistModel->delete($this->request->getVar('idP'));

    }

    public function deleteSong(){
        $songModel=new SongModel();
        $song=$songModel->find($this->request->getVar('idS'));
        $songModel->delete($this->request->getVar('idS'));
        $message="deleted song ".$song->name." - ".$song->artist.
            " from playlist ".$this->playlistToString($song->idP);
        $this->insertToChangeLog($message);
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
        $message="inserted song ".$this->request->getVar('name')." - ".$this->request->getVar('performer').
        " in playlist ".$this->playlistToString($pl[0]->idP);
        $this->insertToChangeLog($message);
    }

    public function insertPlaylist(){
        $playlistModel=new PlaylistModel();
        $pls=$playlistModel->where("genre", $this->request->getVar('genre'))->
            where("difficulty", $this->request->getVar('level'))->findAll();
        $arr=array();
        foreach ($pls as $pl){
            array_push($arr , $pl->number);
        }

        if(count($arr)==0)
            $maxNum=1;
        else $maxNum=max($arr)+1;
        $playlistModel->insert([
            "difficulty" => $this->request->getVar('level'),
            "genre"=>  $this->request->getVar('genre'),
            "number"=> $maxNum
        ]);
        $message="added playlist ".ucfirst($this->request->getVar('genre'))." ".
            ucfirst($this->request->getVar('level'))." ".strVal($maxNum);
        $this->insertToChangeLog($message);
    }

    public function insertToChangeLog($message){
        $changeLogModel=new ChangeLogModel();
        $changeLogModel->insert([
            "operation"=> $message,
            "username"=>$this->session->get('username')
        ]);
        $all=$changeLogModel->findAll();
        if(count($all)>50){
            $toDelete=$changeLogModel->findAll(10);
            foreach ($toDelete as $del){
                $changeLogModel->delete($del->idC);
            }
        }
    }

    public function getAllGenres() {
        $genreModel=new GenreModel();
        $genres=$genreModel->findAll();
        foreach ($genres as $genre){
            echo $genre->name . ",";
        }
    }
    public function getGenres(){
        $genreModel=new GenreModel();
        $genres=$genreModel->findAll();
        foreach ($genres as $genre){
            $name=$genre->name.",";
            echo $name;
        }
    }

    public function updateSong(){

        $songModel=new SongModel();
        $songToBeChanged=$songModel->find($this->request->getVar('songId'));
        $message="changed song ".$songToBeChanged->artist." - ".$songToBeChanged->name." to ";
        if($this->request->getVar('toChange')=="name"){
            $toChange="name";
            $message.=$songToBeChanged->artist." - ".$this->request->getVar('name');
        }
        else {
            $toChange = "artist";
            $message.=$this->request->getVar('name')." - ".$songToBeChanged->name;
        }
        $songModel->where("idS",$this->request->getVar('songId'))->update(null,[$toChange=>$this->request->getVar('name')]);
        $this->insertToChangeLog($message);
    }

}
