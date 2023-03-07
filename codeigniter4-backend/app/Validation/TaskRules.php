<?php

namespace App\Validation;

use App\Constants\TaskPriorityEnum;

use function lang;

class TaskRules
{
    public function valid_priority(string $priority, ?string &$error = null): bool
    {
        if (!TaskPriorityEnum::tryFrom((int) $priority)) {
            $error = lang('Validation.valid_priority', ['field' => 'Priority']);

            return false;
        }

        return true;
    }
}
