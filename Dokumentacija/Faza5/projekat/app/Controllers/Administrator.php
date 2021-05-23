<?php


namespace App\Controllers;


use App\Models\MistakeLogModel;
use App\Models\SongModel;
use App\Models\UserInfoModel;
use App\Models\UserModel;
use phpDocumentor\Reflection\Type;

class Administrator extends BaseController
{
    public function showView($page, $data = []){
        $data['middlePart']= view("pages/$page", $data);
        echo view('patterns/default_page_pattern', $data);
    }

    public function index(){
        $this->showView("adminMenu", []);
    }


    public function getMistakes()
    {
        $mistakeModel = new MistakeLogModel();
        $mistakes = $mistakeModel->findAll();
        foreach ($mistakes as $mistake){
            $mistakeString = $mistake->idM . '/' . $mistake->idS . ',';
            echo $mistakeString;
        }
    }

    public function getSongInfo()
    {
        $songModel = new SongModel();
        $id = $this->request->getVar("idS");
        $song = $songModel->find($id);
        $songString = $song->idS . "," . $song->name . "," . $song->artist;
        echo $songString;
    }

    public function deleteAccount(){
        $users = new UserModel();
        $toDelete =$users->find($this->request->getVar('accountToDelete'));

        if($toDelete!=null) {
            $usersInfo = new UserInfoModel();
            $toDeleteInfo = $usersInfo->where('username', $toDelete->username)->find();
            foreach ($toDeleteInfo as $userInfo){
                $usersInfo->delete($userInfo->id);
            }

            $users->delete($toDelete->username);
            $this->showView("adminMenu", []);
        }
        else{
            $this->showView("deleteAccount", ['errors' => ['accountToDelete' => 'Invalid username']]);
        }
    }

    public function checkModerator()
    {
        $users = new UserModel();
        $username = $this->request->getVar("modUsername");


        $taken = $users->find($username);

        if($taken != null){
            echo "User with that username already exists";
        }
        $users->insert([
            'username' =>  $this->request->getVar("modUsername"),
            'password' => $this->request->getVar("modPassword"),
            'type' => "moderator"
        ]);
        echo "";
    }
}