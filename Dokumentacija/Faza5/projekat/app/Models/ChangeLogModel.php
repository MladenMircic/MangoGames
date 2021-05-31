<?php


namespace App\Models;


use CodeIgniter\Model;

class ChangeLogModel extends Model
{
    protected $table = 'change_log';
    protected $primaryKey = 'idC';
    protected $returnType = 'object';
    protected $useAutoIncrement = true;

    protected $allowedFields = ['idC', 'operation', 'username', 'dateTime'];

}