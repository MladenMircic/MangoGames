<?php

namespace App\Controllers;

use App\Models\GenreModel;
use App\Models\PlaylistModel;
use App\Models\UserInfoModel;
use App\Models\UserModel;
use App\Models\UserPlaylistModel;

/**
 * Class Register - For registering player users in the database
 * @package App\Controllers
 */
class Register extends BaseController
{
    /**
     * A method to show register page
     */
    public function index()
    {
        $this->showView('register');
    }

    /**
     * A method that checks if all the fields required are correctly entered and if a user already exists in the database.
     * Returns the errors if there are any or continues to the genre picking for the new user.
     * @throws \ReflectionException
     */
    public function checkRegisterCredentials()
    {
        if (!$this->validate([
            'username' => 'trim|required|min_length[5]',
            'password' => 'trim|required|min_length[5]',
            'confirmPass' => 'trim|required|matches[password]'
        ])) {
            return $this->showView('register', ['errors' => $this->validator->getErrors()]);
        }

        $this->session->set("username", $this->request->getVar("username"));
        $this->session->set("password", $this->request->getVar("password"));
        return redirect()->to(base_url("Register/pickGenres"));
    }

    /**
     * A method that pulls all the present genres from the database, and sends them to the user for picking
     */
    public function pickGenres(){
        $genreModel=new GenreModel();
        $data['genres'] =$genreModel->findAll();
        foreach ($data['genres'] as $genre)
            $genre->name = ucfirst($genre->name);
        $this->showView('pickGenres',$data);
    }

    /**
     * A method that gets picked genres from the user and inserts them in the database
     * @return \CodeIgniter\HTTP\RedirectResponse
     * @throws \ReflectionException
     */
    public function confirmGenres(){
        /**
         * A user model representing all types of users from database
         */
        $userModel = new UserModel();
        $user = $userModel->find($this->session->get('username'));

        if ($user != null)
            return $this->showView('register', ['errors' => ['username' => 'User already exists.']]);

        $userModel->insert([
            'username' => $this->session->get('username'),
            'password' => $this->session->get('password'),
            'type' => 'user'
        ]);
        $this->session->set("type", "user");
        $this->session->remove("password");

        /**
         * A model that represents user progress in one genre
         */
        $userInfoModel=new UserInfoModel();
        $userInfoModel->insert([
            "username" => $this->session->get("username"),
            "genre" => $this->request->getVar('g1')
        ]);
        $userInfoModel->insert([
            "username" => $this->session->get("username"),
            "genre" =>  $this->request->getVar('g2')
        ]);

        $user_info1 = $userInfoModel
                                    ->where("username", $this->session->get("username"))
                                    ->where("genre", $this->request->getVar('g1'))
                                    ->first();

        $user_info2 = $userInfoModel
                                    ->where("username", $this->session->get("username"))
                                    ->where("genre", $this->request->getVar('g2'))
                                    ->first();

        $userPlaylistModel = new UserPlaylistModel();
        $playlistModel = new PlaylistModel();
        $userPlaylistModel->insert([
            "idU" => $user_info1->idU,
            "idP" => $playlistModel->getIdOfMinNumOfGenre($this->request->getVar('g1'))
        ]);
        $userPlaylistModel->insert([
            "idU" => $user_info2->idU,
            "idP" => $playlistModel->getIdOfMinNumOfGenre($this->request->getVar('g2'))
        ]);

        return redirect()->to(base_url("User"));
    }
}
