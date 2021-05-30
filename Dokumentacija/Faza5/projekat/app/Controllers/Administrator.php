<?php


namespace App\Controllers;


use App\Models\ChangeLogModel;
use App\Models\MistakeLogModel;
use App\Models\SongModel;
use App\Models\UserInfoModel;
use App\Models\UserModel;
use phpDocumentor\Reflection\Type;

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

    /**
     * A method that returns to the administrator all the mistakes reported by the users
     */
    public function getMistakes()
    {
        /**
         * A model that represents a table of mistakes from the database.
         */
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
            echo $log->moderatorUsername.",". $log->operation.",".$log->dateTime."/";
        }
    }
}