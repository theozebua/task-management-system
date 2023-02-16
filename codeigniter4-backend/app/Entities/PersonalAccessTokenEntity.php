<?php

declare(strict_types=1);

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use CodeIgniter\I18n\Time;

/**
 * @property int    $id
 * @property int    $tokenable_id
 * @property string $tokenable_type
 * @property string $name
 * @property string $token
 * @property string $abilities
 * @property Time   $last_used_at
 * @property Time   $expires_at
 * @property Time   $created_at
 * @property Time   $updated_at
 */
class PersonalAccessTokenEntity extends Entity
{
    protected $datamap = [];
    protected $dates   = [
        'created_at',
        'updated_at',
        'last_used_at',
        'expires_at'
    ];
    protected $casts   = [
        'id'           => 'integer',
        'tokenable_id' => 'integer',
    ];
}
