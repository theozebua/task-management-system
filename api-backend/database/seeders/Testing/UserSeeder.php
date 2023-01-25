<?php

declare(strict_types=1);

namespace Database\Seeders\Testing;

use App\Models\User;
use App\Traits\FakeUser;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    use FakeUser;

    public function run(): void
    {
        User::create($this->getUser());
    }
}
