<?php

declare(strict_types=1);

namespace Database\Seeders\Testing;

use App\Constants\TaskPriorityEnum;
use App\Models\Task;
use App\Models\User;
use App\Traits\FakeUser;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    use FakeUser;

    public function run(): void
    {
        Task::create([
            'user_id'     => User::first()->id,
            'title'       => 'Something',
            'description' => 'Something',
            'due_date'    => now()->addDays(7),
            'priority'    => collect(TaskPriorityEnum::cases())->random()->value,
            'is_finished' => fake()->boolean(),
        ]);
    }
}
