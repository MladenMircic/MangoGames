<?php


namespace App\Models;

use CodeIgniter\Model;

class PlaylistModel extends Model
{
    protected $table      = 'playlist';
    protected $primaryKey = 'idP';
    protected $returnType = 'object';
    protected $useAutoIncrement = true;

    protected $allowedFields = ['idP','difficulty', 'genre', 'number','price'];
}