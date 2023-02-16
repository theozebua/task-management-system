<?php

declare(strict_types=1);

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use CodeIgniter\I18n\Time;

/**
 * @property int    $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property Time   $created_at
 * @property Time   $updated_at
 */
class UserEntity extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at'];
    protected $casts   = [
        'id' => 'integer'
    ];
}
