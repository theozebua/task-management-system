<?php

declare(strict_types=1);

namespace App\Database\Seeds;

use App\Entities\UserEntity;
use App\Models\User;
use CodeIgniter\Database\Seeder;

final class UserSeeder extends Seeder
{
    final public function run(): void
    {
        $userEntity = new UserEntity([
            'name'     => 'John Doe',
            'email'    => 'johndoe@gmail.com',
            'password' => 'password',
        ]);

        (new User())->save($userEntity);
    }
}
