<?php


namespace App\Controllers;


use App\Models\GenreModel;


class User extends BaseController
{
    public function showView($page, $data)
    {
        $data['middlePart'] = view($page, $data);
        echo view('patterns/default_page_pattern', $data);
    }

    public function index()
    {

        $this->pickGenres();
    }

    public function pickGenres(){
        $genreModel=new GenreModel();
        $data['genres'] =$genreModel->findAll();
        $this->showView('pages/pickGenres',$data);
    }


}