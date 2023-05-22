<?php

declare(strict_types=1);

namespace Tests\Support\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Tests\Support\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $userModel = new User();

        $userModel->insert([
            'name'     => 'John Doe',
            'email'    => 'johndoe@gmail.com',
            'password' => 'password',
        ]);
    }
}
