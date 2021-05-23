<?php


namespace App\Models;


use CodeIgniter\Model;

class MistakeLogModel extends Model
{
    protected $table = 'mistake_log';
    protected $primaryKey = 'idM';
    protected $returnType = 'object';

    protected $allowedFields = ['idM', 'idS'];

}