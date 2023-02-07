<?php

declare(strict_types=1);

namespace App\Models;

use App\Entities\PersonalAccessTokenEntity;
use CodeIgniter\Model;

class PersonalAccessTokenModel extends Model
{
    protected $table         = 'personal_access_tokens';
    protected $returnType    = PersonalAccessTokenEntity::class;
    protected $allowedFields = [
        'tokenable_id',
        'tokenable_type',
        'name',
        'token',
        'abilities',
        'last_used_at',
        'expires_at,'
    ];
    protected $useTimestamps = true;
}
