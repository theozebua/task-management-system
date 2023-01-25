<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Constants\TaskPriorityEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title'       => fake()->sentence(),
            'description' => fake()->sentences(asText: true),
            'due_date'    => now()->addDays(rand(1, 7)),
            'priority'    => collect(TaskPriorityEnum::cases())->random()->value,
        ];
    }
}
