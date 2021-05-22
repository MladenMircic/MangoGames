<?php


namespace App\Models;


class PlaylistModel extends \CodeIgniter\Model
{
    protected $table      = 'playlist';
    protected $primaryKey = 'idP';
    protected $returnType = 'object';
    protected $useAutoIncrement = true;

    protected $allowedFields = ['idP','difficulty', 'genre', 'number'];
}