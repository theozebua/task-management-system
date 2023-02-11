<?php

namespace App\Validation;

use App\Constants\TaskPriorityEnum;

class TaskRules
{
    public function valid_priority(string $priority): bool
    {
        return TaskPriorityEnum::tryFrom((int) $priority) ? true : false;
    }
}
