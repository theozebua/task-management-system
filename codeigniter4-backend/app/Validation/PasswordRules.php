<?php

declare(strict_types=1);

namespace App\Validation;

use App\Entities\PersonalAccessTokenEntity;

use function password_verify;
use function request;
use function unserialize;

class PasswordRules
{
    public function current_password(string $currentPassword): bool
    {
        /** @var PersonalAccessTokenEntity $accessToken */
        $accessToken = unserialize(request()->header('access-token')->getValue());

        return password_verify(
            $currentPassword,
            (new $accessToken->tokenable_type)
                ->select(['password'])
                ->find($accessToken->tokenable_id)
                ->password
        );
    }
}
