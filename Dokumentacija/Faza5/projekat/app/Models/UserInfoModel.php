<?php


namespace App\Models;
use CodeIgniter\Model;


class UserInfoModel extends \CodeIgniter\Model
{
    protected $table      = 'user_info';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $useAutoIncrement = true;

    protected $allowedFields = ['id','username', 'genre', 'points', 'tokens'];



}