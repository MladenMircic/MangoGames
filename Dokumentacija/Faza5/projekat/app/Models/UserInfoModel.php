<?php


namespace App\Models;
use CodeIgniter\Model;


class UserInfoModel extends \CodeIgniter\Model
{
    protected $table      = 'user_info';
    protected $primaryKey = 'username';
    protected $returnType = 'object';

    protected $allowedFields = ['username', 'genre', 'points', 'tokens'];



}