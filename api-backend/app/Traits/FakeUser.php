<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\User;
use Database\Seeders\Testing\UserSeeder;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;

trait FakeUser
{
    public string $name     = 'John Doe';
    public string $email    = 'johndoe@gmail.com';
    public string $password = 'password';
    public User   $user;

    public function getUser(): array
    {
        return [
            'name'     => $this->name,
            'email'    => $this->email,
            'password' => Hash::make($this->password),
        ];
    }

    public function actingAsFakeUser(): void
    {
        $this->seed(UserSeeder::class);

        $this->user = User::first();

        Sanctum::actingAs($this->user);
    }
}
