<?php

declare(strict_types=1);

namespace App\Models;

use App\Contracts\HasApiTokensContract;
use App\Entities\UserEntity;
use App\Traits\HasApiTokens;
use CodeIgniter\Model;

class UserModel extends Model implements HasApiTokensContract
{
    use HasApiTokens;

    protected $table         = 'users';
    protected $returnType    = UserEntity::class;
    protected $allowedFields = [
        'name',
        'email',
        'password',
    ];
    protected $useTimestamps = true;
    protected $beforeInsert  = ['hashPassword'];

    protected function hashPassword(array $data): array
    {
        if (!isset($data['data']['password'])) {
            return $data;
        }

        $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);

        return $data;
    }
}
