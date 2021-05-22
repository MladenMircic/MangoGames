<?php


namespace App\Models;


class SongModel extends \CodeIgniter\Model
{
    protected $table      = 'song';
    protected $primaryKey = 'idS';
    protected $returnType = 'object';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['idS','name', 'artist', 'path', 'idP'];
}