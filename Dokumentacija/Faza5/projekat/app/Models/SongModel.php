<?php


namespace App\Models;

use CodeIgniter\Model;

class SongModel extends Model
{
    protected $table      = 'song';
    protected $primaryKey = 'idS';
    protected $returnType = 'object';
    protected $useAutoIncrement = true;

    protected $allowedFields = ['idS','name', 'artist', 'path', 'idP'];
}