<?php

declare(strict_types=1);

namespace Tests\Support\Database\Seeds;

use App\Constants\TaskPriorityEnum;
use App\Models\User;
use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;
use Tests\Support\Models\Task;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $taskModel = new Task();

        $taskModel->insert([
            'user_id'     => (new User())->first()->id,
            'title'       => 'Something',
            'description' => 'Something',
            'due_date'    => Time::now()->addDays(7),
            'priority'    => TaskPriorityEnum::cases()[array_rand(TaskPriorityEnum::cases())]->value,
            'is_finished' => (bool) random_int(0, 1),
        ]);
    }
}
