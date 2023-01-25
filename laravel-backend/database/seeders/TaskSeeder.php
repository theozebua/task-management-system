<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\{Task, User};
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        User::all()->each(function (User $user) {
            Task::factory(rand(1, 5))->create([
                'user_id' => $user->id,
            ]);
        });
    }
}
