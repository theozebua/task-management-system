<?php

declare(strict_types=1);

namespace App\Constants;

enum TaskPriorityEnum: int
{
    case LOW    = 1;
    case MEDIUM = 2;
    case HIGH   = 3;
}
