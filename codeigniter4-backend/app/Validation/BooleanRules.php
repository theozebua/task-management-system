<?php

declare(strict_types=1);

namespace App\Validation;

use function in_array;
use function lang;

class BooleanRules
{
    public function boolean(mixed $isFinished, ?string &$error = null): bool
    {
        $booleanish = [true, false, 1, 0, '1', '0'];

        if (!in_array($isFinished, $booleanish, true)) {
            $error = lang('Validation.boolean', ['field' => 'Is Finished']);

            return false;
        }

        return true;
    }
}
