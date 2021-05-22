<?php


namespace App\Controllers;


use App\Models\UserInfoModel;
use App\Models\UserModel;

class Administrator extends BaseController
{
    public function showView($page, $data = []){
        $data['middlePart']= view("pages/$page", $data);
        echo view('patterns/default_page_pattern', $data);
    }

    public function index(){
        $this->showView("adminMenu", []);
    }

    public function leaderboards(){
        echo view("pages/temp.html");
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
}