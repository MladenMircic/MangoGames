<?php

namespace App\Models;

use CodeIgniter\Model;

class GenreModel extends Model
{
    protected $table = 'genre';
    protected $primary= 'name';
    protected $returnType='object';

    protected $allowedFields = ['name'];
}
