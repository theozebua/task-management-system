<?php

declare(strict_types=1);

namespace App\Models;

use App\Entities\UserEntity;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table         = 'users';
    protected $returnType    = UserEntity::class;
    protected $allowedFields = [
        'name',
        'email',
        'password',
    ];
    protected $useTimestamps = true;
}
