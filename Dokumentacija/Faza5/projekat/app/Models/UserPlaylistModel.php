<?php
namespace App\Models;

use CodeIgniter\Model;

class UserPlaylistModel extends Model
{
    protected $table = 'user_playlist';
    protected $primaryKey = 'idUP';
    protected $returnType = 'object';
    protected $useAutoIncrement = true;

    protected $allowedFields = ['idUP', 'idU', 'idP'];

}