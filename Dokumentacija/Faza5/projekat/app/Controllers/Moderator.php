<?php

namespace App\Controllers;

use App\Models\ChangeLogModel;
use App\Models\GenreModel;
use App\Models\PlaylistModel;
use App\Models\SongModel;
use App\Models\MistakeLogModel;

/**
 * Class Moderator - Represents all the functionalities that aa moderator has
 * @package App\Controllers
 */
class Moderator extends PrivilegedUser
{

    /**
     * A method to show main moderator page
     */
    public function index()
    {
        $this->showView('modMenu');
    }

    /**
     * An optional method which a class can implement if additional data is required by the showView method
     * @return array
     */
    protected function showAdditionalData() {
        return ['welcomeMessage' => "Welcome, {$this->session->get('username')} <br> <div style='color: blue'>Moderator</div>"];
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
}
