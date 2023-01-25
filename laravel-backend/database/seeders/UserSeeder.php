<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'John Doe',
            'email'    => 'johndoe@gmail.com',
            'password' => Hash::make('password'),
        ]);

        User::factory(50)->create();
    }
}
