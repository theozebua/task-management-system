<?php

declare(strict_types=1);

namespace App\Entities\Cast;

use App\Constants\TaskPriorityEnum;
use CodeIgniter\Entity\Cast\BaseCast;

class TaskPriorityCast extends BaseCast
{
    public static function get($value, array $params = []): ?TaskPriorityEnum
    {
        return TaskPriorityEnum::tryFrom((int) $value);
    }
}
