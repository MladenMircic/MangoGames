<?php


namespace App\Controllers;


use App\Models\ChangeLogModel;
use App\Models\UserInfoModel;
use App\Models\UserModel;
use App\Models\UserPlaylistModel;

/**
 * Class Administrator - Represents all the functionalities that an administrator has
 * @package App\Controllers
 */
class Administrator extends PrivilegedUser
{

    /**
     * A method to show main administrator page
     */
    public function index(){
        $this->showView("adminMenu");
    }

    /**
     * An optional method which a class can implement if additional data is required by the showView method
     * @return array
     */
    protected function showAdditionalData()
    {
        return ['welcomeMessage' => "Welcome, {$this->session->get('username')} <br> <div style='color: purple'>Administrator</div>"];
    }



    public function deleteAccount(){
        $users = new UserModel();
        $toDelete =$users->find($this->request->getVar('accountToDelete'));

        if($toDelete!=null) {
            $usersInfo = new UserInfoModel();
            $userPlaylistModel = new UserPlaylistModel();
            $toDeleteInfo = $usersInfo->where('username', $toDelete->username)->findAll();

            foreach ($toDeleteInfo as $userInfo) {
                $userPlaylistModel->where("idU", $userInfo->idU)->delete();
                $usersInfo->delete($userInfo->id);
            }

            $users->delete($toDelete->username);
            echo "";
        }
        else{
            echo "Invalid username";
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
    public function getChangeLog(){
        $changeLogModel=new ChangeLogModel();
        $logs=$changeLogModel->findAll();
        foreach ($logs as $log){
            echo $log->username.",". $log->operation.",".$log->dateTime."/";
        }
    }
}